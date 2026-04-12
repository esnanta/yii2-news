<?php

namespace common\helper;

use common\service\LayoutService;
use yii\web\View;

class MetaHelper
{
    public static function setMetaTags(array $overrides = []): void
    {
        $defaults = \Yii::$app->params['metaTags'] ?? [];
        $dynamic = self::dynamicOverrides();

        // default -> dynamic -> explicit overrides
        $metaTags = array_replace_recursive($defaults, $dynamic, $overrides);

        // Backward compatibility for existing layout that reads root params.
        foreach ($metaTags as $key => $tagConfig) {
            \Yii::$app->params[$key] = $tagConfig;
        }

        // Optional: keep normalized map for future loop-based registration.
        \Yii::$app->params['metaTagsResolved'] = $metaTags;
    }

    /**
     * Returns normalized meta tags ready for registration in views.
     */
    public static function getResolvedMetaTags(array $overrides = []): array
    {
        self::setMetaTags($overrides);

        $resolvedMetaTags = \Yii::$app->params['metaTagsResolved']
            ?? \Yii::$app->params['metaTags']
            ?? [];

        if ([] !== $resolvedMetaTags) {
            return $resolvedMetaTags;
        }

        // Last fallback for legacy flat params shape.
        $legacyMetaKeys = [
            'meta_author',
            'meta_description',
            'meta_keywords',
            'og_site_name',
            'og_title',
            'og_description',
            'og_type',
            'og_url',
            'og_image',
            'og_width',
            'og_height',
            'og_updated_time',
            'twitter_title',
            'twitter_description',
            'twitter_card',
            'twitter_url',
            'twitter_image',
            'googleplus_name',
            'googleplus_description',
            'googleplus_image',
        ];

        foreach ($legacyMetaKeys as $metaKey) {
            if (isset(\Yii::$app->params[$metaKey]) && is_array(\Yii::$app->params[$metaKey])) {
                $resolvedMetaTags[$metaKey] = \Yii::$app->params[$metaKey];
            }
        }

        return $resolvedMetaTags;
    }

    /**
     * Registers all resolved meta tags to provided view.
     */
    public static function registerMetaTags(View $view, array $overrides = []): void
    {
        foreach (self::getResolvedMetaTags($overrides) as $metaKey => $metaConfig) {
            if (is_array($metaConfig) && isset($metaConfig['content'])) {
                $view->registerMetaTag($metaConfig, (string) $metaKey);
            }
        }
    }

    private static function dynamicOverrides(): array
    {
        $result = [];

        $result['og_site_name']['content'] = (string) \Yii::$app->name;

        $absoluteUrl = self::getCurrentAbsoluteUrl();
        if (null !== $absoluteUrl) {
            $result['og_url']['content'] = $absoluteUrl;
            $result['twitter_url']['content'] = $absoluteUrl;
        }

        $description = trim(LayoutService::getDescription());
        if ('' !== $description) {
            $result['meta_description']['content'] = $description;
            $result['og_description']['content'] = $description;
            $result['twitter_description']['content'] = $description;
            $result['googleplus_description']['content'] = $description;
        }

        $keywords = trim(LayoutService::getKeyWord());
        if ('' !== $keywords) {
            $result['meta_keywords']['content'] = $keywords;
        }

        // If LayoutService already has getLogoUrl(), use it for social image.
        if (method_exists(LayoutService::class, 'getLogoUrl')) {
            $logoUrl = LayoutService::getLogoUrl('logo_top');
            if (self::isValidMetaUrl($logoUrl)) {
                $result['og_image']['content'] = $logoUrl;
                $result['twitter_image']['content'] = $logoUrl;
                $result['googleplus_image']['content'] = $logoUrl;
            }
        }

        // Keep og_updated_time fresh.
        $result['og_updated_time']['content'] = date('c');

        return $result;
    }

    private static function getCurrentAbsoluteUrl(): ?string
    {
        if (\Yii::$app->request->isConsoleRequest) {
            return null;
        }

        try {
            return \Yii::$app->request->absoluteUrl;
        } catch (\Throwable $e) {
            return null;
        }
    }

    private static function isValidMetaUrl(?string $url): bool
    {
        if (null === $url || '' === trim($url)) {
            return false;
        }

        return false !== filter_var($url, FILTER_VALIDATE_URL);
    }
}
