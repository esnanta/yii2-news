<?php

namespace common\service;

use common\helper\IconHelper;
use common\helper\ImageHelper;
use common\helper\LabelHelper;
use common\models\Asset;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Yii;
use yii\base\Exception;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use ZipArchive;

class AssetService
{

    /**
     * Upload asset file
     * @param Asset $asset
     * @return UploadedFile|false
     */
    public function uploadAsset(Asset $asset): UploadedFile|bool
    {
        $uploadedFile = UploadedFile::getInstance($asset, 'asset');

        // Abort if no asset is uploaded
        if (empty($uploadedFile)) {
            return false;
        }

        $baseTitle = preg_replace('/[.,\/\s]/', '_', pathinfo($asset->title, PATHINFO_FILENAME));
        $ext = pathinfo($uploadedFile->name, PATHINFO_EXTENSION);
        $uploadedFile->name = "{$baseTitle}_" . uniqid() . ".{$ext}";

        return $uploadedFile;
    }

    /**
     * Delete asset file from server
     * @param Asset $asset
     * @return bool
     * @throws Exception
     */
    public function deleteAsset(Asset $asset): bool
    {
        $file = $this->getAssetFile($asset);

        if (empty($file) || !file_exists($file)) {
            return false;
        }

        if (!unlink($file)) {
            return false;
        } else {
            $asset->asset_name = null;
            $asset->asset_url = null;
        }

        return true;
    }

    /**
     * Get asset file path
     * @param Asset $asset
     * @return string|null
     * @throws Exception
     */
    public function getAssetFile(Asset $asset): ?string
    {
        $directory = self::createBackendDirectory(self::getPath($asset));
        return (!empty($asset->asset_name)) ? $directory.'/'. $asset->asset_name : '';
    }

    public function getAssetUrl(Asset $asset): string
    {
        if($asset->asset_type != Asset::ASSET_TYPE_IMAGE){
            return self::getDefaultImage();
        }

        $path = self::getPath($asset);
        $fileName = $asset->asset_name;

        // Set default image if fileName is empty
        $assetName = !empty($fileName) ? $fileName : self::getDefaultImage();
        $filePath = (new AssetService())->getWebRoot() . $path . '/' . $assetName;

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
    public function createBackendDirectory($path): string
    {
        $directory = str_replace('frontend', 'backend', Yii::getAlias('@webroot')) . $path;
        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory, $mode = 0777);
        }
        return $directory;
    }

    /**
     * Extract asset file
     * @param Asset $asset
     * @throws Exception
     */
    public function extract(Asset $asset): void
    {
        if($asset->asset_type==Asset::ASSET_TYPE_COMPRESSION) {
            $fileSource = $this->getAssetFile($asset);
            $extractDir = $this->getExtractDir($asset);

            $zip = new ZipArchive;
            $zip->open($fileSource);
            $zip->extractTo($extractDir);
            $zip->close();
        }
    }

    /**
     * Get extract directory
     * @param Asset $asset
     * @return string|null
     * @throws Exception
     */
    public function getExtractDir(Asset $asset): ?string
    {
        $combinedName = $this->getExtractFolderName($asset);
        $directory = str_replace('backend', 'frontend', Yii::getAlias('@webroot')) . $this->getPath($asset) . '/' . $combinedName;
        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory, $mode = 0777);
        }
        return $directory;
    }

    /**
     * Remove extract folder recursively
     * @param string $dir
     */
    public function removeExtractFolder(string $dir): void
    {
        $it = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($files as $file) {
            if ($file->isDir()) {
                rmdir($file->getPathname());
            } else {
                unlink($file->getPathname());
            }
        }
        rmdir($dir);
    }

    // Utility methods for asset paths
    public function getWebRoot(): string
    {
        return str_replace('frontend', 'backend', Yii::getAlias('@webroot'));
    }

    public function getPath(Asset $asset): string
    {
        $officeUniqueId = $asset->office->unique_id;
        return '/uploads/asset/' . $officeUniqueId;
    }

    private function getExtractFolderName(Asset $asset): string
    {
        $title = str_replace(' ', '_', $asset->title);
        return $asset->id . '_' .$title;
    }

    public function getExtractUrl(Asset $asset): string
    {
        $indexFile = $this->getPath($asset) . '/' .
            $this->getExtractFolderName($asset) . '/index.html';
        return Yii::$app->urlManager->baseUrl . $indexFile;
    }

    /**
     * @throws Exception
     */
    public function renderIndexFileStatus(Asset $asset): string
    {
        $filePath = $this->getExtractDir($asset).'/index.html';

        // Use check and cross icons
        $checkIcon = LabelHelper::getInfo(IconHelper::getCheck()) ;
        $exclamationIcon = LabelHelper::getWarning(IconHelper::getExclamation());

        // Return check icon if file exists, otherwise cross icon
        return file_exists($filePath) ? $checkIcon : $exclamationIcon;
    }

    public function getDefaultImage(): string
    {
        return str_replace('frontend', 'backend', ImageHelper::getNotAvailable()) ;
    }
}