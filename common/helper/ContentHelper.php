<?php
namespace common\helper;

use common\domain\AssetUseCase;
use DOMDocument;
use DOMXPath;
use Yii;
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

    public static function getCover($content,$coverUrl=null): string
    {
        // If the cover URL is not null, use it directly
        if (!empty($coverUrl)) {
            return $coverUrl;
        }

        // Otherwise, proceed to check the content for the first image
        [$dom, $xpath] = self::getXPath($content);
        $srcImage = $xpath->evaluate("string(//img/@src)");

        // Check if the srcImage is base64 or a URL
        if (!empty($srcImage)) {
            if (self::isBase64($srcImage)) {
                return $srcImage; // Base64 image can be used directly
            }

            // Define the path where the images are stored
            $imagePath = (new AssetUseCase)->getWebRoot() . $srcImage;

            // Check if the image exists physically
            if (is_file($imagePath) && file_exists($imagePath)) {
                return $srcImage;
            } else {
                // Try to clean up the path in case of admin URL issues
                $srcImage = str_replace('/main/admin', '', $srcImage);
                $imagePath = (new AssetUseCase)->getWebRoot() . $srcImage;

                if (is_file($imagePath) && file_exists($imagePath)) {
                    return Yii::$app->urlManager->baseUrl . $srcImage;
                } else {
                    return AssetUseCase::getDefaultImage();
                }
            }
        } else {
            return AssetUseCase::getDefaultImage(); // Fallback to default if no image found
        }
    }

    // Helper function to check if a string is a base64-encoded image
    private static function isBase64($string): bool
    {
        return (bool) preg_match('/^data:image\/(jpeg|png|gif|bmp);base64,/', $string);
    }

    public static function getLogo($content,$width,$height): array|string
    {
        $style = 'width:'.$width.';height:'.$height;
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