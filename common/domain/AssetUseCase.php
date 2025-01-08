<?php

namespace common\domain;

use common\helper\ImageHelper;
use Yii;
use yii\base\Exception;
use yii\helpers\FileHelper;

class AssetUseCase
{

    public function getWebRoot() : String
    {
        return Yii::getAlias('@backend/web');
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

    public static function getFileUrl($path, $fileName): string
    {
        // Set default image if fileName is empty
        $assetName = !empty($fileName) ? $fileName : self::getDefaultImage();
        $filePath = (new AssetUseCase)->getWebRoot() . $path . '/' . $assetName;

        // Check if the file exists
        if (file_exists($filePath)) {
            return Yii::$app->urlManager->baseUrl . $path . '/' . $assetName;
        }

        // Return default image if file doesn't exist
        return self::getDefaultImage();
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
        return str_replace('frontend', 'backend', ImageHelper::getNotAvailable()) ;
    }
}