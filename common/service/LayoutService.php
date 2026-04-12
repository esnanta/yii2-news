<?php

namespace common\service;

use common\models\ArticleCategory;
use common\models\KeyStorageItem;
use common\models\Office;
use common\models\OfficeSocialAccount;
use common\models\Page;
use common\models\WidgetImage;
use yii\db\ActiveRecord;
use yii\helpers\Html;

class LayoutService
{
    public static function getLayoutData(
        string $logo1Width = '200px',
        string $logo1Height = '60px',
        string $logo2Width = '500px',
        string $logo2Height = '90px'
    ): array {
        $office = self::getOffice();
        $officeId = $office?->id;

        return [
            'office' => $office,
            'categories' => self::getCategories($officeId),
            'officeMedias' => self::getSocialLinks($officeId),
            'logo1Image' => self::getLogo1($logo1Width, $logo1Height),
            'logo2Image' => self::getLogo2($logo2Width, $logo2Height),
        ];
    }

    public static function getLogo1(
        string $width = '100px',
        string $height = '40px',
        array $options = []
    ): string {
        return self::renderWidgetImageByKey('logo_top', $width, $height, $options);
    }

    public static function getLogo2(
        string $width = '100px',
        string $height = '40px',
        array $options = []
    ): string {
        return self::renderWidgetImageByKey('logo_bottom', $width, $height, $options);
    }

    public static function getLogoUrl(string $key = 'logo_top'): ?string
    {
        $model = self::getWidgetImageByKey($key);
        if (null === $model) {
            return null;
        }

        return FileDisplayService::resolvePublicUrl($model->base_url, $model->path);
    }

    public static function getDescription(): string
    {
        $model = KeyStorageItem::find(['value'])->where(['key' => 'frontend.meta.description'])->one();

        return empty($model->value) ? '' : strip_tags($model->value);
    }

    public static function getKeyWord(): string
    {
        $model = KeyStorageItem::find(['value'])->where(['key' => 'frontend.meta.keywords'])->one();

        return empty($model->value) ? '' : strip_tags($model->value);
    }

    public static function getAbout(): ActiveRecord|array|null
    {
        return Page::find()->where(['slug' => 'about'])->one();
    }

    public static function getOffice(): ?Office
    {
        $office = Office::find()->orderBy(['id' => SORT_ASC])->one();

        return $office instanceof Office ? $office : null;
    }

    public static function getCategories(?int $officeId): array
    {
        if (null === $officeId) {
            return [];
        }

        return ArticleCategory::find()
            ->where([
                'office_id' => $officeId,
                'status' => ArticleCategory::STATUS_ACTIVE,
            ])
            ->orderBy(['sequence' => SORT_ASC])
            ->all()
        ;
    }

    /**
     * Returns link/icon objects to keep a legacy header view contract.
     */
    public static function getSocialLinks(?int $officeId): array
    {
        if (null === $officeId) {
            return [];
        }

        $accounts = OfficeSocialAccount::find()
            ->with('platform')
            ->where(['office_id' => $officeId, 'is_visible' => 1])
            ->orderBy(['sequence' => SORT_ASC, 'id' => SORT_ASC])
            ->all()
        ;

        $items = [];
        foreach ($accounts as $account) {
            $url = trim((string) ($account->profile_url ?: $account->description));
            if ('' === $url) {
                continue;
            }

            $items[] = (object) [
                'title' => self::resolveSocialIconClass($account),
                'description' => $url,
            ];
        }

        return $items;
    }

    /**
     * Render widget image by key as tag <img>.
     */
    public static function renderWidgetImageByKey(
        string $key,
        string $width = '100px',
        string $height = '40px',
        array $options = []
    ): string {
        $model = self::getWidgetImageByKey($key);
        if (null === $model) {
            return '';
        }

        $url = FileDisplayService::resolvePublicUrl($model->base_url, $model->path);
        if (null === $url) {
            return '';
        }

        $defaultOptions = [
            'alt' => (string) ($model->alt_text ?: $model->title ?: $key),
            'style' => 'width: '.$width.'; height: '.$height.';',
            'loading' => 'lazy',
            'decoding' => 'async',
        ];

        return Html::img($url, array_merge($defaultOptions, $options));
    }

    /**
     * Metadata widget image by key.
     */
    public static function getWidgetImageByKey(string $key): ?WidgetImage
    {
        $model = WidgetImage::find()->where(['key' => $key])->one();

        return $model instanceof WidgetImage ? $model : null;
    }

    private static function resolveSocialIconClass(OfficeSocialAccount $account): string
    {
        $code = strtolower((string) ($account->platform->code ?? ''));
        $map = [
            'facebook' => 'fab fa-facebook-f',
            'twitter' => 'fab fa-twitter',
            'x' => 'fab fa-x-twitter',
            'instagram' => 'fab fa-instagram',
            'linkedin' => 'fab fa-linkedin-in',
            'youtube' => 'fab fa-youtube',
            'tiktok' => 'fab fa-tiktok',
            'telegram' => 'fab fa-telegram-plane',
            'whatsapp' => 'fab fa-whatsapp',
        ];

        return $map[$code] ?? 'fas fa-link';
    }
}
