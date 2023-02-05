<?php

namespace backend\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

use \backend\models\base\Archive as BaseArchive;

/**
 * This is the model class for table "tx_archive".
 */
class Archive extends BaseArchive
{

    public $asset;

    //HANYA UNTUK INFO DI VIEW BACKEND
    public $file;
    public $url;
    //END HANYA UNTUK INFO DI VIEW BACKEND

    public static $path='/uploads/archive';

    const IS_VISIBLE_PRIVATE            = 1;
    const IS_VISIBLE_PUBLIC             = 2;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            //TAMBAHAN
            [['is_visible','archive_category_id'], 'required'],
            [['asset'], 'file', 'maxSize' => (1024 * 1024 * 5), 'tooBig' => 'Limit is 5MB'],

            [['is_visible', 'archive_category_id', 'date_issued', 'size', 'view_counter', 'download_counter', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['description'], 'string'],
            [['title', 'file_name'], 'string', 'max' => 200],
            [['archive_url'], 'string', 'max' => 500],
            [['mime_type'], 'string', 'max' => 100],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }


    public function attributeLabels()
    {
        return [
            'id'                    => 'ID',
            'is_visible'            => Yii::$app->params['Attribute_IsVisible'],
            'archive_category_id'   => Yii::$app->params['Attribute_Category'],
            'title'                 => Yii::$app->params['Attribute_Title'],
            'date_issued'           => Yii::$app->params['Attribute_DateIssued'],
            'file_name'             => Yii::$app->params['Attribute_FileName'],
            'archive_url'           => Yii::$app->params['Attribute_Url'],
            'size'                  => 'Size',
            'mime_type'             => 'Mime',
            'view_counter'          => Yii::$app->params['Attribute_ViewCounter'],
            'download_counter'      => Yii::$app->params['Attribute_DownloadCounter'],
            'description'           => Yii::$app->params['Attribute_Description'],
            'created_at'            => Yii::$app->params['Attribute_CreatedAt'],
            'updated_at'            => Yii::$app->params['Attribute_UpdatedAt'],
            'created_by'            => Yii::$app->params['Attribute_CreatedBy'],
            'updated_by'            => Yii::$app->params['Attribute_UpdatedBy'],

            'is_deleted'            => 'Deleted',
            'deleted_at'            => Yii::$app->params['Attribute_DeletedAt'],
            'deleted_by'            => Yii::$app->params['Attribute_DeletedBy'],

            'verlock'               => 'Verlock',
        ];
    }

    public function beforeSave($insert) {


        if ($this->isNewRecord) {
            $this->download_counter     = 0;
            $this->view_counter         = 0;
        }

        return parent::beforeSave($insert);
    }

    public static function getArrayIsVisible()
    {
        return [
            //MASTER
            self::IS_VISIBLE_PRIVATE => 'Private',
            self::IS_VISIBLE_PUBLIC  => 'Public',
        ];
    }

    public static function getOneIsVisible($_module = null)
    {
        if($_module)
        {
            $arrayModule = self::getArrayIsVisible();
            $returnValue = 'NULL';

            switch ($_module) {
                case ($_module == self::IS_VISIBLE_PRIVATE):
                    $returnValue = '<span class="label label-danger">'.$arrayModule[$_module].'</span>';
                    break;
                case ($_module == self::IS_VISIBLE_PUBLIC):
                    $returnValue = '<span class="label label-primary">'.$arrayModule[$_module].'</span>';
                    break;
                default:
                    $returnValue = '<span class="label label-default">'.$arrayModule[$_module].'</span>';
            }

            return $returnValue;

        }
        else
            return;
    }

    public function downloadFile($path) {
        if (!empty($path)) {
            //header("Content-type:application/pdf"); //for pdf file

            header('Content-Type:text/plain; charset=ISO-8859-15');
            //if you want to read text file using text/plain header
            header('Content-Disposition: attachment; filename="' . basename($path) . '"');
            header('Content-Length: ' . filesize($path));
            readfile($path);

            $this->download_counter = $this->download_counter+1;
            $this->save();

            Yii::app()->end();
        }
    }

    /**
     * fetch stored asset file name with complete path
     * @return string
     */
    public function getAssetFile()
    {
        $directory  = str_replace('frontend', 'backend', Yii::getAlias('@webroot')) . self::$path;
        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory, $mode = 0777);
        }
        return (!empty($this->file_name)) ? $directory.'/'. $this->file_name : null;
    }

    /**
     * fetch stored asset url
     * @return string
     */
    public function getAssetUrl()
    {
        // return a default image placeholder if your source avatar is not found
        $defaultImage = '/images/no-picture-available-icon-1.jpg';
        $file_name = (!empty($this->file_name)) ? $this->file_name : $defaultImage;
        $directory = str_replace('frontend', 'backend', Yii::getAlias('@webroot')) . self::$path;

        if (file_exists($directory.'/'.$file_name)) {
            $file_parts = pathinfo($directory.'/'.$file_name);
            if($file_parts['extension']=='pdf'){
                Yii::$app->urlManager->baseUrl . self::$path.'/'.$file_name;
            }
            
            return Yii::$app->urlManager->baseUrl . self::$path.'/'.$file_name;
        }
        else{
            return Yii::$app->urlManager->baseUrl . $defaultImage;
        }
    }

    /**
    * Process upload of asset
    *
    * @return mixed the uploaded asset instance
    */
    public function uploadAsset() {
        // get the uploaded file instance. for multiple file uploads
        // the following data will return an array (you may need to use
        // getInstances method)
        $asset = UploadedFile::getInstance($this, 'asset');

        // if no asset was uploaded abort the upload
        if (empty($asset)) {
            return false;
        }

        // store the source file name
        if($this->title==''){
            $this->title = $asset->name;
        }

        //generate a unique file name
        //$ext = end((explode(".", $asset->name)));
        $deleteExt          = substr($this->title, 0, strpos($this->title, "."));
        $replaceSpace       = str_replace(' ','_', $deleteExt);
        $replaceSlash       = str_replace('/','_', $replaceSpace);
        $replaceComma       = str_replace(',','_', $replaceSlash);
        $replaceDot         = str_replace('.','_', $replaceComma);
        $title              = $replaceDot;
        $tmp                = explode('.', $asset->name);
        $ext                = end($tmp);          
        $this->file_name    = $title.'_'.uniqid().".{$ext}";
        
        // the uploaded asset instance
        return $asset;
    }

    /**
    * Process deletion of asset
    *
    * @return boolean the status of deletion
    */
    public function deleteAsset() {
        $file = $this->getAssetFile();

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
        return Yii::$app->getUrlManager()->createUrl(['archive/view', 'id' => $this->id, 'title' => $this->title]);
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
