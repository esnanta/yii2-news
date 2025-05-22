<?php

namespace common\models;

use common\helper\ImageHelper;
use common\models\base\Author as BaseAuthor;
use common\service\AssetService;
use common\service\CacheService;
use Yii;
use yii\base\Exception;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class Author extends BaseAuthor
{

    public function rules(): array
    {
        return [
            //TIDAK PERLU TAMBAHAN
            //PENGATURAN FILE MENYEBABKAN ERROR UNTUK KASUS CROPPING
            //[['file_name'], 'file', 'extensions'=>'jpg, gif, png, jpeg','maxSize' => (1024 * 1024 * 1), 'tooBig' => 'Limit is 1Mb'],

            [['office_id', 'user_id', 'created_by', 'updated_by', 'is_deleted', 'deleted_by', 'verlock'], 'integer'],
            [['address', 'description'], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['title', 'email', 'file_name'], 'string', 'max' => 100],
            [['phone_number'], 'string', 'max' => 50],
            [['uuid'], 'string', 'max' => 36],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }
    private function getPath() : string {
        $officeUniqueId = CacheService::getInstance()->getOfficeUniqueId();
        return '/uploads/author/'.$officeUniqueId;
    }

    /**
     * fetch stored image file name with complete path
     * @return string
     * @throws Exception
     */
    /**
     * fetch stored image file name with complete path
     * @return string
     * @throws Exception
     */
    public function getAssetFile($isTemporary=false): string
    {
        $directory = str_replace('frontend', 'backend', Yii::getAlias('@webroot')) . $this->getPath();
        if ($isTemporary) :
            $directory = str_replace('frontend', 'backend', Yii::getAlias('@webroot')) . $this->getTmpPath();
        endif;

        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory, $mode = 0777);
        }
        return (!empty($this->file_name)) ? $directory.'/'. $this->file_name : '';
    }


    public function getAssetUrl(): string
    {
        // return a default image placeholder if your source avatar is not found
        $defaultImage = '/images/if_skype2512x512_197582.png';
        $file_name = (!empty($this->file_name)) ? $this->file_name : $defaultImage;
        $directory = str_replace('frontend', 'backend', Yii::getAlias('@webroot')) . $this->getPath();

        if (file_exists($directory.'/'.$file_name)) {
            $file_parts = pathinfo($directory.'/'.$file_name);
            if($file_parts['extension']=='pdf'){
                Yii::$app->urlManager->baseUrl . $this->getPath().'/'.$file_name;
            }

            return Yii::$app->urlManager->baseUrl . $this->getPath().'/'.$file_name;
        }
        else{
            return Yii::$app->urlManager->baseUrl . $defaultImage;
        }
    }

    public function createBackendDirectory($path): string
    {
        $directory = str_replace('frontend', 'backend', Yii::getAlias('@webroot')) . $path;
        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory, $mode = 0777);
        }
        return $directory;
    }

    public function getDefaultImage(): string
    {
        return str_replace('frontend', 'backend', ImageHelper::getNotAvailable()) ;
    }

    /**
    * Process upload of image
    *
    * @return mixed the uploaded image instance
    */
    public function uploadImage() {
        // get the uploaded file instance. for multiple file uploads
        // the following data will return an array (you may need to use
        // getInstances method)
        $image = UploadedFile::getInstance($this, 'file_name');

        // if no image was uploaded abort the upload
        if (empty($image)) {
            return false;
        }

        // store the source file name
        if($this->title==''){
            $this->title = $image->name;
        }
        
        // generate a unique file name
        //$ext = end((explode(".", $image->name)));
        $tmp = explode('.', $image->name);
        $ext = end($tmp);  
        $this->file_name = Yii::$app->security->generateRandomString().".{$ext}";

        // the uploaded image instance
        return $image;
    }    
    
    /**
    * Process deletion of image
    *
    * @return boolean the status of deletion
    */
    public function deleteAsset() {
        $file = $this->getAssetFile();

        if(AssetService::deleteFile($file)){
            $this->file_name = null;
            return true;
        }
        else{
            return false;
        }
    }

    public function getUrl()
    {
        return Yii::$app->getUrlManager()->createUrl(['author/view', 'id' => $this->id, 'title' => $this->title]);
    }
}
