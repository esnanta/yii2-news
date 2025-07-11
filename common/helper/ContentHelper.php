<?php

namespace common\helper;

use common\service\AssetService;
use DOMDocument;
use yii\helpers\Html;

class ContentHelper
{
    /**
     * Validate the size of images in the content.
     *
     * @param string $content
     * @param int    $maxFileSize
     *
     * @return bool|string
     */
    public static function validateImageSize($content, $maxFileSize = 300 * 1024)
    {
        $matches = [];
        preg_match_all('/<img[^>]+src="data:image\/[^;]+;base64,([^"]+)"/', $content, $matches);

        foreach ($matches[1] as $base64Str) {
            $fileSize = (strlen($base64Str) * (3 / 4)) - (str_contains($base64Str, '=') ? (strlen($base64Str) - strpos($base64Str, '=')) : 0);
            if ($fileSize > $maxFileSize) {
                return 'One or more images exceed the maximum allowed size of 300 KB.';
            }
        }

        return true;
    }

    /*     * *******************************************************************
      Purpose       : function to truncate text and show read more links.
      Parameters    : @$story_desc : story description
      @$link        : story link
      @$targetFile  : target redirect file name
      @$id          : story id
      Returns       : string
     * ********************************************************************* */

    public static function readMore($content, $size = null): string
    {
        // KEEP TAGS BODY, DELETE OTHER TAGS
        $html = strip_tags($content, '<body>');

        // CUT TEXT
        $chars = (!empty($size)) ? $size : 150;
        $tmpContent = substr($html, 0, $chars);

        return substr($tmpContent, 0, strrpos($tmpContent, ' '));
    }

    public static function configureContentImage($content): array|bool|string
    {
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($content);
        $xpath = new \DOMXPath($dom);

        foreach ($xpath->query('//img') as $node) {
            $node->setAttribute('class', 'img-responsive img-fluid');
        }

        return str_replace('%09', '', $dom->saveHtml());
    }

    public static function configureContentTable($content): array|bool|string
    {
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($content);
        $xpath = new \DOMXPath($dom);

        foreach ($xpath->query('//table') as $node) {
            $node->setAttribute('class', 'table table-striped');
            $node->setAttribute('style', '');
        }

        return str_replace('%09', '', $dom->saveHtml());
    }

    public static function getCover($content, $coverUrl = null): string
    {
        // If the cover URL is not null, use it directly
        if (!empty($coverUrl)) {
            return $coverUrl;
        }

        // Otherwise, proceed to check the content for the first image
        [$dom, $xpath] = self::getXPath($content);
        $srcImage = $xpath->evaluate('string(//img/@src)');

        // Check if the srcImage is base64 or a URL
        if (!empty($srcImage)) {
            if (self::isBase64($srcImage)) {
                return $srcImage; // Base64 image can be used directly
            }

            // Define the path where the images are stored
            $imagePath = (new AssetService())->getWebRoot().$srcImage;

            // Check if the image exists physically
            if (is_file($imagePath) && file_exists($imagePath)) {
                return \Yii::$app->urlManager->baseUrl.$srcImage;
            }
            // Try to clean up the path in case of admin URL issues
            $srcImage = str_replace('/main/admin', '', $srcImage);
            $imagePath = (new AssetService())->getWebRoot().$srcImage;

            if (is_file($imagePath) && file_exists($imagePath)) {
                return \Yii::$app->urlManager->baseUrl.$srcImage;
            }

            return (new AssetService())->getDefaultImage();
        }

        return (new AssetService())->getDefaultImage(); // Fallback to default if no image found
    }

    public static function getLogo($content, $width, $height): array|string
    {
        $style = 'width:'.$width.';height:'.$height;
        $class = 'img-fluid';
        if (!empty($content)) {
            [$dom, $xpath] = self::getXPath($content);

            // Remove <p> and <br> tags
            $pTags = $xpath->query('//p');
            foreach ($pTags as $pTag) {
                while ($pTag->firstChild) {
                    $pTag->parentNode->insertBefore($pTag->firstChild, $pTag);
                }
                $pTag->parentNode->removeChild($pTag);
            }

            $brTags = $xpath->query('//br');
            foreach ($brTags as $brTag) {
                $brTag->parentNode->removeChild($brTag);
            }

            // Set attributes for all <img> elements
            $images = $xpath->query('//img');
            foreach ($images as $img) {
                $img->setAttribute('style', $style);
                $img->setAttribute('class', $class);
            }

            return str_replace('<br>', '', $dom->saveHTML());
        }

        return Html::img((new AssetService())->getDefaultImage(), ['class' => $class, 'style' => $style]);
    }

    /**
     * Cleans HTML content by removing empty tags and converting non-breaking spaces.
     *
     * @param string $html the HTML content to clean
     *
     * @return string the cleaned HTML content
     */
    public static function cleanHtmlContent(string $html): string
    {
        // Pastikan konten adalah string dan tidak kosong
        if (empty($html)) {
            return '';
        }

        // DOMDocument membutuhkan header HTML lengkap untuk parsing yang akurat,
        // terutama untuk menangani encoding.
        // Kita membungkusnya dalam dummy HTML.
        // Penting: gunakan meta charset untuk memastikan DOMDocument memparsing sebagai UTF-8
        $wrappedHtml = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body>'.$html.'</body></html>';

        $dom = new \DOMDocument();
        // Menonaktifkan error libxml untuk mencegah warning/error parsing HTML yang tidak sempurna
        libxml_use_internal_errors(true);

        // Memuat HTML. Penting untuk menentukan encoding
        // Jika Anda memuat fragmen HTML, loadHTML might prepend doctype, html, body tags.
        // LIBXML_HTML_NOIMPLIED dan LIBXML_HTML_NODEFDTD membantu menghindari ini.
        $dom->loadHTML($wrappedHtml, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        // Setelah memuat, pastikan encoding DOMDocument diatur ke UTF-8
        // Ini adalah langkah penting untuk memastikan output yang benar
        $dom->encoding = 'UTF-8';

        $xpath = new \DOMXPath($dom);

        // 1. Menghilangkan empty tags (misal: <p></p>, <span></span>)
        // Ini adalah proses iteratif karena menghapus satu tag bisa membuat tag
        // induknya menjadi kosong
        // Contoh: <p><span></span></p> -> <span></span> akan dihapus, lalu <p></p>
        // akan menjadi kosong.
        do {
            $removed = false;
            // Pilih semua elemen yang TIDAK memiliki atribut, TIDAK memiliki anak elemen,
            // DAN memiliki konten teks kosong (termasuk whitespace)
            // Atau elemen yang hanya berisi entitas whitespace
            $nodes = $xpath->query('//*[not(normalize-space()) and not(@*) and count(./*) = 0]');

            if (0 === $nodes->length) {
                // Juga tangani tag yang hanya berisi <br> atau &nbsp;
                $nodes = $xpath->query("//*[count(./*) = count(./br | ./text()[normalize-space()=''] | ./text()[.='\xC2\xA0'])]");
            }

            foreach ($nodes as $node) {
                // Jangan hapus tag tertentu yang mungkin diinginkan kosong, misal: <br>, <hr>, <img>
                if (in_array($node->nodeName, ['br', 'hr', 'img', 'input', 'meta', 'link'])) {
                    continue;
                }

                // Periksa lagi apakah node memang kosong setelah normalisasi
                // (terutama untuk kasus yang hanya berisi whitespace/nbsp)
                if ('' === trim($node->textContent)) {
                    // Check if it's truly empty or only contains whitespace or non-breaking spaces
                    $isTrulyEmpty = true;
                    foreach ($node->childNodes as $child) {
                        // If it's a text node, check if it's only whitespace or non-breaking space
                        if (XML_TEXT_NODE === $child->nodeType && '' !== trim($child->nodeValue)) {
                            $isTrulyEmpty = false;

                            break;
                        }
                        // If it's an element node, and not a self-closing tag, then it's not truly empty
                        if (XML_ELEMENT_NODE === $child->nodeType
                            && !in_array($child->nodeName, ['br', 'hr', 'img', 'input', 'meta', 'link'])) {
                            $isTrulyEmpty = false;

                            break;
                        }
                    }

                    if ($isTrulyEmpty) {
                        $node->parentNode->removeChild($node);
                        $removed = true;
                    }
                }
            }
        } while ($removed); // Ulangi selama ada node yang dihapus

        // 2. Mengganti &nbsp; dengan spasi biasa
        // DOMDocument biasanya mengurai &nbsp; menjadi karakter Unicode U+00A0
        // Kita bisa menargetkan node teks dan mengganti karakter ini.
        $textNodes = $xpath->query('//text()');
        foreach ($textNodes as $textNode) {
            $originalValue = $textNode->nodeValue;
            // Mengganti karakter U+00A0 (non-breaking space) dengan spasi biasa
            $newValue = str_replace("\xC2\xA0", ' ', $originalValue); // Untuk UTF-8 NBSP
            $newValue = str_replace("\xA0", ' ', $newValue);         // Untuk Latin-1 NBSP (jika ada)

            if ($newValue !== $originalValue) {
                $textNode->nodeValue = $newValue;
            }
        }

        // Mendapatkan kembali HTML yang sudah dibersihkan
        // saveHTML($dom->getElementsByTagName('body')->item(0)) akan mengambil hanya konten body
        $cleanedHtml = $dom->saveHTML($dom->getElementsByTagName('body')->item(0));

        // Hapus tag <body> dan </body> yang mungkin ditambahkan loadHTML
        $cleanedHtml = preg_replace('/^<body>/', '', $cleanedHtml);
        $cleanedHtml = preg_replace('/<\/body>$/', '', $cleanedHtml);

        // Kembalikan error handling libxml ke setting default
        libxml_use_internal_errors(false);

        return $cleanedHtml;
    }

    private static function getXPath($content): array
    {
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new \DOMXPath($dom);

        return [$dom, $xpath];
    }

    // Helper function to check if a string is a base64-encoded image
    private static function isBase64($string): bool
    {
        return (bool) preg_match('/^data:image\/(jpeg|png|gif|bmp);base64,/', $string);
    }
}
