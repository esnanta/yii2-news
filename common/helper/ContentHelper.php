<?php
namespace common\helper;

use common\domain\AssetUseCase;
use DOMDocument;
use DOMXPath;
use yii\helpers\Html;

class ContentHelper
{

    /**
     * Validate the size of images in the content
     *
     * @param string $content
     * @param integer $maxFileSize
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

    public static function readMore($content,$size=null): string
    {
        /*
         * KEEP TAGS BODY, DELETE OTHER TAGS
         */
        $html = strip_tags($content,'<body>');

        /*
         * CUT TEXT
         */
        $chars = (!empty($size)) ? $size : 150;
        $tmpContent = substr($html, 0, $chars);
        return substr($tmpContent, 0, strrpos($tmpContent, ' '));
    }

    public static function configureContentImage($content): array|bool|string
    {
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($content);
        $xpath = new DOMXPath($dom);

        foreach ($xpath->query("//img") as $node) {
            $node->setAttribute("class", "img-responsive img-fluid");
        }

        return str_replace('%09', '', $dom->saveHtml());
    }

    public static function configureContentTable($content): array|bool|string
    {
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($content);
        $xpath = new DOMXPath($dom);

        foreach ($xpath->query("//table") as $node) {
            $node->setAttribute("class", "table table-striped");
            $node->setAttribute("style", "");
        }

        return str_replace('%09', '', $dom->saveHtml());
    }

    private static function getXPath($content): array
    {
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new DOMXPath($dom);
        return [$dom, $xpath];
    }

    public static function getCover($content): string
    {
        [$dom, $xpath] = self::getXPath($content);

        $srcImage   = $xpath->evaluate("string(//img/@src)");

        // Define the path where the images are stored
        $imagePath = (new AssetUseCase)->getWebRoot() . '/uploads/blog';  // Update with the actual path

        if (!empty($srcImage)) {
            // Get the basename of the image (without URL part)
            $imageFile = basename($srcImage);

            // Full path to the image file
            $fullPath = $imagePath . '/' . $imageFile;

            // Check if the file exists physically
            if (is_file($fullPath) && file_exists($fullPath)) {
                $value = $srcImage;
            } else {
                $value = AssetUseCase::getDefaultImage();
            }
        } else {
            $value = AssetUseCase::getDefaultImage();
        }

        return $value;
    }

    public static function getLogo($content): array|string
    {
        $style = 'width:100px;height:40px';
        $class = 'img-fluid';
        if (!empty($content)) {
            [$dom, $xpath] = self::getXPath($content);

            // Remove <p> and <br> tags
            $pTags = $xpath->query("//p");
            foreach ($pTags as $pTag) {
                while ($pTag->firstChild) {
                    $pTag->parentNode->insertBefore($pTag->firstChild, $pTag);
                }
                $pTag->parentNode->removeChild($pTag);
            }

            $brTags = $xpath->query("//br");
            foreach ($brTags as $brTag) {
                $brTag->parentNode->removeChild($brTag);
            }

            // Set attributes for all <img> elements
            $images = $xpath->query("//img");
            foreach ($images as $img) {
                $img->setAttribute("style", $style);
                $img->setAttribute("class", $class);
            }

            return str_replace('<br>', '', $dom->saveHTML());
        } else {
            return Html::img(AssetUseCase::getDefaultImage(),['class'=>$class,'style' => $style]);
        }

    }
}