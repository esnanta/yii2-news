<?php

namespace backend\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use \backend\models\base\ThemeDetail as BaseThemeDetail;

class ThemeDetail extends BaseThemeDetail
{
    public $image;
    public static $path='/uploads/theme';   
    
    /**
     * @inheritdoc
     */ 
    public function rules()
    {
        return [
            //TAMBAHAN
            [['theme_id'], 'required'],
            [['image'], 'file', 'extensions'=>'jpg, gif, png, jpeg','maxSize' => (500 * 1024 * 1024), 'tooBig' => 'Limit is 1MB'],                        
            
            [['theme_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['content', 'description'], 'string'],
            [['title'], 'string', 'max' => 100],
            [['file_name'], 'string', 'max' => 200],
            [['token'], 'string', 'max' => 5],
            [['token'], 'unique'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Theme::className(), 'targetAttribute' => ['theme_id' => 'id']],
            [['verlock', 'is_deleted'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']            
        ];        
        
    }       
    
    public static function getArraySocMed()
    {
        return [
            //MASTER
            self::SOCMED_ICONS_1  => 'Fecebook',
            self::SOCMED_ICONS_2  => 'Twitter',
            self::SOCMED_ICONS_3  => 'Youtube',
            self::SOCMED_ICONS_4  => 'Instagram',
            self::SOCMED_ICONS_5  => 'Github',
        ];
    }
    
    public static function getOneSocMed($_module = null)
    {
        if($_module)
        {
            $arrayModule = self::getArrayIsVisible();
            $returnValue = 'NULL';

            switch ($_module) {
                
                default:
                    $returnValue = '<span class="label label-success">'.$arrayModule[$_module].'</span>';
            }

            return $returnValue;

        }
        else
            return;
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
        $file_name = isset($this->file_name) ? 
            Yii::$app->urlManager->baseUrl .self::$path.'/'.$this->file_name : 
            Yii::$app->urlManager->baseUrl .'/images/no-picture-available-icon-1.jpg';
        return $file_name;
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

        //generate a unique file name
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
        //$this->title = null;

        return true;
    }        
    
    public static function getByToken($token)
    {
        $model = ThemeDetail::find()->where(['token' => $token])->one();
        return $model;
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
