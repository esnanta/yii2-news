<?php

namespace common\service;

use yii\helpers\Html;

class FileDisplayService
{
    public static function resolvePublicUrl(?string $baseUrl, ?string $path): ?string
    {
        $normalizedPath = trim((string) $path);
        if ('' === $normalizedPath) {
            return null;
        }

        $normalizedBaseUrl = trim((string) $baseUrl);
        if ('' === $normalizedBaseUrl) {
            try {
                $normalizedBaseUrl = \Yii::getAlias('@storageUrl');
            } catch (\Throwable $e) {
                return null;
            }
        }

        return rtrim($normalizedBaseUrl, '/').'/'.ltrim($normalizedPath, '/');
    }

    public static function renderImageOrFallback(
        ?string $title,
        ?string $baseUrl,
        ?string $path,
        string $fallbackText,
        array $imageOptions = []
    ): string {
        $url = self::resolvePublicUrl($baseUrl, $path);
        if (null === $url) {
            return $fallbackText;
        }

        return Html::img($url, array_merge([
            'alt' => (string) $title,
            'style' => 'max-width: 180px; height: auto;',
        ], $imageOptions));
    }

    public static function formatSizeInKbOrMb($size): ?string
    {
        if (!is_numeric($size)) {
            return null;
        }

        $bytes = (float) $size;
        if (!is_finite($bytes) || $bytes < 0) {
            return null;
        }

        $oneMb = 1024 * 1024;
        if ($bytes >= $oneMb) {
            return \Yii::$app->formatter->asDecimal($bytes / $oneMb, 2).' MB';
        }

        return \Yii::$app->formatter->asDecimal($bytes / 1024, 2).' KB';
    }
}
