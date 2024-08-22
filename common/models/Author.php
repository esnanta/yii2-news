<?php

namespace common\models;

use common\domain\AssetUseCase;
use common\models\base\Author as BaseAuthor;
use common\service\CacheService;
use Yii;
use yii\base\Exception;
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
    public function getAssetFile(): string
    {
        return AssetUseCase::getFile($this->getPath(),$this->file_name);
    }

    /**
     * fetch stored image url
     * @return string
     */  
    public function getAssetUrl()
    {
        return AssetUseCase::getUrl($this->getPath(), $this->file_name);
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
    public function deleteImage() {
        $file = $this->getImageFile();

        if(AssetUseCase::deleteFile($file)){
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
