<?php

namespace common\service;

use common\models\KeyStorageItem;
use common\models\Page;
use common\models\WidgetImage;
use yii\db\ActiveRecord;
use yii\helpers\Html;

class LayoutService
{
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

    /**
     * Jika nanti dibutuhkan URL mentah (misalnya untuk meta tag og:image).
     */
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
}
