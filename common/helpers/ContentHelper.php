<?php

namespace common\helper;

use common\service\FileDisplayService;
use yii\helpers\StringHelper;

class ContentHelper
{
    /**
     * Ambil ringkasan plain-text dari HTML.
     */
    public static function excerpt(string $html, int $length = 160): string
    {
        $text = trim(preg_replace('/\s+/u', ' ', strip_tags($html)));
        if ('' === $text) {
            return '';
        }

        return StringHelper::truncate($text, $length, '...', null, true);
    }

    /**
     * Normalisasi HTML agar konsisten untuk frontend mana pun.
     * - opsional hapus inline style
     * - opsional injeksi class per tag
     * - bersihkan tag kosong
     * - normalisasi NBSP.
     */
    public static function normalizeHtml(
        string $html,
        array $tagClassMap = [],
        bool $removeInlineStyle = true
    ): string {
        if ('' === trim($html)) {
            return '';
        }

        [$dom, $xpath] = self::createDom($html);

        if ($removeInlineStyle) {
            foreach ($xpath->query('//*[@style]') as $node) {
                $node->removeAttribute('style');
            }
        }

        foreach ($tagClassMap as $tag => $classes) {
            $classString = trim(implode(' ', array_filter((array) $classes)));
            if ('' === $classString) {
                continue;
            }

            foreach ($xpath->query('//'.$tag) as $node) {
                self::appendClass($node, $classString);
            }
        }

        self::removeEmptyElements($xpath);
        self::normalizeNbsp($xpath);

        return self::extractBodyInnerHtml($dom);
    }

    /**
     * Cover resolver baru:
     * 1) thumbnail article (base_url + path)
     * 2) first image dari body
     * 3) fallback
     */
    public static function resolveCoverUrl(
        ?string $thumbnailBaseUrl,
        ?string $thumbnailPath,
        ?string $bodyHtml = null,
        ?string $fallbackUrl = null
    ): ?string {
        $thumbnailUrl = FileDisplayService::resolvePublicUrl($thumbnailBaseUrl, $thumbnailPath);
        if (null !== $thumbnailUrl) {
            return $thumbnailUrl;
        }

        $firstImage = self::extractFirstImageSrc((string) $bodyHtml);
        if (null !== $firstImage) {
            return $firstImage;
        }

        return $fallbackUrl;
    }

    /**
     * Ambil src image pertama dari HTML.
     */
    public static function extractFirstImageSrc(string $html): ?string
    {
        if ('' === trim($html)) {
            return null;
        }

        [$dom, $xpath] = self::createDom($html);
        $src = trim((string) $xpath->evaluate('string(//img[1]/@src)'));
        if ('' === $src) {
            return null;
        }

        if (self::isAbsoluteOrDataUrl($src)) {
            return $src;
        }

        $fromStorage = FileDisplayService::resolvePublicUrl(null, $src);

        return $fromStorage ?? $src;
    }

    private static function createDom(string $html): array
    {
        $wrapped = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body>'.$html.'</body></html>';

        $dom = new \DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        $dom->loadHTML($wrapped, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $dom->encoding = 'UTF-8';

        $xpath = new \DOMXPath($dom);

        return [$dom, $xpath];
    }

    private static function extractBodyInnerHtml(\DOMDocument $dom): string
    {
        $body = $dom->getElementsByTagName('body')->item(0);
        if (null === $body) {
            return '';
        }

        $html = '';
        foreach ($body->childNodes as $child) {
            $html .= $dom->saveHTML($child);
        }

        return $html;
    }

    private static function appendClass(\DOMElement $node, string $classToAppend): void
    {
        $existing = trim((string) $node->getAttribute('class'));
        $merged = trim($existing.' '.$classToAppend);
        if ('' !== $merged) {
            $node->setAttribute('class', $merged);
        }
    }

    private static function removeEmptyElements(\DOMXPath $xpath): void
    {
        do {
            $removed = false;
            $nodes = $xpath->query('//*[not(@*) and count(./*) = 0 and normalize-space(.) = ""]');

            foreach ($nodes as $node) {
                $tag = strtolower($node->nodeName);
                if (in_array($tag, ['br', 'hr', 'img', 'input', 'meta', 'link'], true)) {
                    continue;
                }

                if (null !== $node->parentNode) {
                    $node->parentNode->removeChild($node);
                    $removed = true;
                }
            }
        } while ($removed);
    }

    private static function normalizeNbsp(\DOMXPath $xpath): void
    {
        foreach ($xpath->query('//text()') as $textNode) {
            $value = (string) $textNode->nodeValue;
            $value = str_replace("\xC2\xA0", ' ', $value);
            $value = str_replace("\xA0", ' ', $value);
            $textNode->nodeValue = $value;
        }
    }

    private static function isAbsoluteOrDataUrl(string $url): bool
    {
        return 1 === preg_match('#^(https?:)?//#i', $url)
            || 1 === preg_match('#^data:image/(jpeg|jpg|png|gif|bmp|webp);base64,#i', $url);
    }
}
