<?php

namespace backend\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use \backend\models\base\Photo as BasePhoto;

class Photo extends BasePhoto
{
    public $image;
    public static $path='/uploads/photo';
    
    /**
     * @inheritdoc
     */   
    public function rules()
    {
        return [
            //TAMBAHAN
            [['image'], 'file', 'extensions'=>'jpg, gif, png, jpeg','maxSize' => (500 * 1024), 'tooBig' => 'Limit is 500KB'],            
            
            [['album_id', 'size', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['description'], 'string'],
            [['title', 'file_name'], 'string', 'max' => 200],
            [['url', 'thumb'], 'string', 'max' => 500],
            [['mime_type'], 'string', 'max' => 20],
            [['verlock', 'is_deleted'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']            
        ];
    }      
    
    /**
     * fetch stored image file name with complete path 
     * @return string
     */
    public function getImageFile() 
    {
        $directory = str_replace('frontend', 'backend', Yii::getAlias('@webroot')) . self::$path;
        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory, $mode = 0777);      
        }
        return (!empty($this->file_name)) ? $directory.'/'. $this->file_name : '';
    }  
    
    /**
     * fetch stored image url
     * @return string
     */
    public function getImageUrl()
    {
        // return a default image placeholder if your source avatar is not found
        $defaultImage = '/images/default_user.jpg';
        $file_name = isset($this->file_name) ? $this->file_name : $defaultImage;
        $directory = str_replace('frontend', 'backend', Yii::getAlias('@webroot')) . self::$path;

        if (file_exists($directory.'/'.$file_name)) {
            return Yii::$app->urlManager->baseUrl . self::$path.'/'.$file_name;
        }
        else{
            return Yii::$app->urlManager->baseUrl . $defaultImage;
        }
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
        $image = UploadedFile::getInstance($this, 'image');

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

        // check if file exists on server
        if (empty($file) || !file_exists($file)) {
            return false;
        }

        // check if uploaded file can be deleted on server
        if (!unlink($file)) {
            return false;
        }

        // if deletion successful, reset your file attributes
        $this->file_name = null;
        $this->title = null;

        return true;
    }    
   
    
    /**
     *
     */
    public function getUrl()
    {
        return Yii::$app->getUrlManager()->createUrl(['photo/view', 'id' => $this->id, 'title' => $this->title]);
    }    

    public function behaviors() {
        return [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }     
}
