<?php

namespace common\domain;

use common\helper\ImageHelper;
use Yii;
use yii\base\Exception;
use yii\helpers\FileHelper;

class AssetUseCase
{

    private function getWebRoot() : String
    {
        return str_replace('frontend', 'backend', Yii::getAlias('@webroot'));
    }

    /**
     * @throws Exception
     */
    public static function createBackendDirectory($path): string
    {
        $directory = (new AssetUseCase)->getWebRoot() . $path;
        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory, $mode = 0777);
        }
        return $directory;
    }

    public static function getUrl($path,$fileName): string
    {
        // return a default image placeholder if your source avatar is not found
        $defaultImage = self::getDefaultImage();
        $asset_name = (!empty($fileName)) ? $fileName : $defaultImage;
        $directory = (new AssetUseCase)->getWebRoot() . $path;

        if (file_exists($directory.'/'.$asset_name)) {
            $file_parts = pathinfo($directory.'/'.$asset_name);
            if($file_parts['extension']=='pdf'){
                Yii::$app->urlManager->baseUrl . $path.'/'.$asset_name;
            }

            return Yii::$app->urlManager->baseUrl . $path.'/'.$asset_name;
        }
        else{
            return $defaultImage;
        }
    }

    /**
     * @throws Exception
     */
    public static function getFile($path, $fileName): string
    {
        $directory = self::createBackendDirectory($path);
        return (!empty($fileName)) ? $directory.'/'. $fileName : '';
    }

    public static function deleteFile($file): bool
    {
        // check if file exists on server
        if (empty($file) || !file_exists($file)) {
            return false;
        }
        else{
            // check if uploaded file can be deleted on server
            if (!unlink($file)) {
                return false;
            }
            // can delete
            else{
                return true;
            }
        }
    }

    public static function getDefaultImage(): string
    {
        return ImageHelper::getNotAvailable();
    }
}