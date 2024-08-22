<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;

use common\models\base\Quote as BaseQuote;

/**
 * This is the model class for table "tx_quote".
 */
class Quote extends BaseQuote
{
    
    public static $path='/uploads/quote';   
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['content', 'description'], 'string'],
            [['created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['title', 'source'], 'string', 'max' => 100],
            [['file_name'], 'string', 'max' => 200],
            [['verlock', 'is_deleted'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }
	
    /**
     *
     */
    public function getUrl()
    {
        return Yii::$app->getUrlManager()->createUrl(['quote/view', 'id' => $this->id, 'title' => $this->title]);
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
        //$file_name = 'no_image.jpg';
        $file_name = isset($this->file_name) ? $this->file_name : 'no_image.jpg';
        return Yii::$app->urlManager->baseUrl .self::$path.'/'. $file_name;
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
        
        return true;
    }   

}
