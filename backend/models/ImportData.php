<?php

namespace backend\models;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use \backend\models\base\ImportData as BaseImportData;

/**
 * This is the model class for table "tx_import_data".
 */
class ImportData extends BaseImportData
{
    //MASTER
    const MODUL_TYPE_ACCOUNT_TYPE               = 1;
    const MODUL_TYPE_ACCOUNT                    = 2;
    const MODUL_TYPE_ALBUM                      = 3;
    const MODUL_TYPE_ARCHIVE                    = 4;
    const MODUL_TYPE_AREA                       = 5;
    const MODUL_TYPE_AUTHOR                     = 6;
    const MODUL_TYPE_CATEGORY                   = 7;
    const MODUL_TYPE_COUNTER                    = 8;
    const MODUL_TYPE_EMPLOYMENT                 = 9;
    const MODUL_TYPE_NETWORK                    = 10;
    const MODUL_TYPE_STAFF                      = 11;
    const MODUL_TYPE_CUSTOMER                   = 12;
    const MODUL_TYPE_ENROLMENT                  = 13;
    const MODUL_TYPE_SERVICE_TYPE               = 14;
    const MODUL_TYPE_GMAP                       = 15;
    const MODUL_TYPE_GMAP_DETAIL                = 16;
    const MODUL_TYPE_BLOG                       = 17;
    const MODUL_TYPE_TAG                        = 18;
    
    //TRANSAKSI
    const MODUL_TYPE_ACCOUNT_PAYABLE            = 21;
    const MODUL_TYPE_ACCOUNT_PAYABLE_DETAIL     = 22;
    const MODUL_TYPE_ACCOUNT_RECEIVABLE         = 23;
    const MODUL_TYPE_ACCOUNT_RECEIVABLE_DETAIL  = 24;
    const MODUL_TYPE_OUTLET                     = 25;
    const MODUL_TYPE_OUTLET_DETAIL              = 26;
    const MODUL_TYPE_VALIDITY                   = 27;
    const MODUL_TYPE_VALIDITY_DETAIL            = 28;         
    const MODUL_TYPE_BILLING                    = 29;    
    const MODUL_TYPE_RECEIVABLE                 = 30;
    const MODUL_TYPE_RECEIVABLE_DETAIL          = 31;    
    const MODUL_TYPE_SERVICE                    = 32;
    const MODUL_TYPE_SERVICE_DETAIL             = 33;      
    
    const MODUL_TYPE_CREATE_UPDATE              = 34;      
    
    public $asset;
    
    //HANYA UNTUK INFO DI VIEW BACKEND
    public $file;
    public $url;
    //END HANYA UNTUK INFO DI VIEW BACKEND
    
    public static $path='/uploads/import';    
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //TAMBAHAN
            [['asset'], 'file', 'maxSize' => (20000 * 1024), 'tooBig' => 'Limit is 20MB'],            

            [['modul_type', 'row_start', 'row_end', 'create_time', 'update_time', 'create_by', 'update_by', 'verlock'], 'integer'],
            [['description'], 'string'],
            [['title', 'file_name'], 'string', 'max' => 100],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']          
        ];
        
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                => 'ID',
            'modul_type'        => Yii::$app->params['Attribute_Type'],
            'title'             => Yii::$app->params['Attribute_Title'],
            'row_start'         => Yii::$app->params['Attribute_RowStart'],
            'row_end'           => Yii::$app->params['Attribute_RowEnd'],
            'file_name'         => Yii::$app->params['Attribute_FileName'],
            'description'       => Yii::$app->params['Attribute_Description'],
            'create_time'       => Yii::$app->params['Attribute_CreateTime'],
            'update_time'       => Yii::$app->params['Attribute_UpdateTime'],
            'create_by'         => Yii::$app->params['Attribute_CreateBy'],
            'update_by'         => Yii::$app->params['Attribute_UpdateBy'],
            'verlock'           => 'Varlock',
        ];
    }
        
    
    /**
     * @inheritdoc
     */
    public static function getArrayModule()
    {
        
    //MASTER

        return [
            //MASTER
            self::MODUL_TYPE_ACCOUNT_TYPE               => 'ACCOUNT_TYPE',
            self::MODUL_TYPE_ACCOUNT                    => 'ACCOUNT',
            self::MODUL_TYPE_ALBUM                      => 'ALBUM',
            self::MODUL_TYPE_ARCHIVE                    => 'ARCHIVE',
            self::MODUL_TYPE_AREA                       => 'AREA',
            self::MODUL_TYPE_AUTHOR                     => 'AUTHOR',
            self::MODUL_TYPE_CATEGORY                   => 'CATEGORY',
            self::MODUL_TYPE_COUNTER                    => 'COUNTER',
            self::MODUL_TYPE_EMPLOYMENT                 => 'EMPLOYMENT',
            self::MODUL_TYPE_NETWORK                    => 'NETWORK',
            self::MODUL_TYPE_STAFF                      => 'STAFF',
            self::MODUL_TYPE_CUSTOMER                   => 'CUSTOMER',
            self::MODUL_TYPE_ENROLMENT                  => 'ENROLMENT',
            self::MODUL_TYPE_SERVICE_TYPE               => 'SERVICE_TYPE', 
            self::MODUL_TYPE_GMAP                       => 'GMAP', 
            self::MODUL_TYPE_GMAP_DETAIL                => 'GMAP DETAIL', 
            self::MODUL_TYPE_BLOG                       => 'BLOG', 
            self::MODUL_TYPE_TAG                        => 'TAG', 
            
            //TRANSAKSI
            self::MODUL_TYPE_ACCOUNT_PAYABLE            => 'ACCOUNT_PAYABLE',
            self::MODUL_TYPE_ACCOUNT_PAYABLE_DETAIL     => 'ACCOUNT_PAYABLE_DETAIL',
            self::MODUL_TYPE_ACCOUNT_RECEIVABLE         => 'ACCOUNT_RECEIVABLE',
            self::MODUL_TYPE_ACCOUNT_RECEIVABLE_DETAIL  => 'ACCOUNT_RECEIVABLE_DETAIL',
            self::MODUL_TYPE_OUTLET                     => 'OUTLET',
            self::MODUL_TYPE_OUTLET_DETAIL              => 'OUTLET_DETAIL',
            self::MODUL_TYPE_VALIDITY                   => 'VALIDITY',
            self::MODUL_TYPE_VALIDITY_DETAIL            => 'VALIDITY_DETAIL',         
            self::MODUL_TYPE_BILLING                    => 'BILLING',    
            self::MODUL_TYPE_RECEIVABLE                 => 'RECEIVABLE',
            self::MODUL_TYPE_RECEIVABLE_DETAIL          => 'RECEIVABLE_DETAIL',    
            self::MODUL_TYPE_SERVICE                    => 'SERVICE',
            self::MODUL_TYPE_SERVICE_DETAIL             => 'SERVICE_DETAIL',              

            self::MODUL_TYPE_CREATE_UPDATE              => 'CREATE UPDATE',  
                      
        ];
    }    
    
    public static function getOneModule($_module = null)
    {
        if($_module)
        {
            $arrayModule = self::getArrayModule();
            return $arrayModule[$_module];
        }
        else
            return;
    }    

    /**
     * fetch stored asset file name with complete path 
     * @return string
     */
    public function getAssetFile() 
    {
        $directory = Yii::getAlias('@webroot') . self::$path;
        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory, $mode = 0777);      
        }
        return isset($this->file_name) ? $directory.'/'. $this->file_name : null;
    }   
    
    /**
     * fetch stored asset url
     * @return string
     */
    public function getAssetUrl() 
    {
        // return a default asset placeholder if your source avatar is not found
        $file_name = isset($this->file_name) ? $this->file_name : 'default_user.jpg';
        return Yii::$app->urlManager->baseUrl .self::$path.'/'. $file_name;
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
        //if($this->title==''){
            $this->title = $asset->name;
        //}
        
        // generate a unique file name
        //$ext = end((explode(".", $asset->name)));
        $tmp = explode('.', $asset->name);
        $ext = end($tmp);          
        $this->file_name = Yii::$app->security->generateRandomString().".{$ext}";

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
	
}
