<?php

namespace common\helper;

use common\service\LayoutService;

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
