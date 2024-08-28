<?php

namespace common\models;

use common\domain\AssetUseCase;
use common\helper\LabelHelper;
use common\models\base\Staff as BaseStaff;
use common\service\CacheService;
use Yii;
use yii\base\Exception;
use yii\web\UploadedFile;

class Staff extends BaseStaff
{
    
    const GENDER_MALE           = 1;
    const GENDER_FEMALE         = 2;       
    
    const ACTIVE_STATUS_YES     = 1;
    const ACTIVE_STATUS_NO      = 2;
    
    public $asset;
      
    /**
     * @inheritdoc
     */   
    public function rules(): array
    {
        return [
            //TAMBAHAN
            [['asset'], 'file', 'extensions'=>'jpg, gif, png, jpeg','maxSize' => (500 * 1024), 'tooBig' => 'Limit is 500KB'],

            [['office_id', 'user_id', 'employment_id', 'gender_status', 'active_status', 'created_by', 'updated_by', 'is_deleted', 'deleted_by', 'verlock'], 'integer'],
            [['address', 'description'], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['title', 'identity_number', 'email', 'google_plus', 'instagram', 'facebook', 'twitter'], 'string', 'max' => 100],
            [['initial'], 'string', 'max' => 3],
            [['phone_number'], 'string', 'max' => 50],
            [['file_name'], 'string', 'max' => 200],
            [['uuid'], 'string', 'max' => 36],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ];        
    }    
    
    public function beforeSave($insert): bool
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->isNewRecord) {       
            $this->active_status    = self::ACTIVE_STATUS_YES;
        }
        
        return true;
    }        
    
    public static function getArrayGenderStatus(): array
    {
        return [
            //MASTER
            self::GENDER_MALE       => Yii::t('app', 'Male') ,
            self::GENDER_FEMALE     => Yii::t('app', 'Female'),
        ];
    }    
    
    public static function getOneGenderStatus($_module = null): string
    {
        if($_module)
        {
            $arrayModule = self::getArrayGenderStatus();

            switch ($_module) {
                case ($_module == self::GENDER_MALE):
                    $returnValue = LabelHelper::getPrimary($arrayModule[$_module]);
                    break;
                case ($_module == self::GENDER_FEMALE):
                    $returnValue = LabelHelper::getSuccess($arrayModule[$_module]);
                    break;
                default:
                    $returnValue = LabelHelper::getDefault('-');
            }

            return $returnValue;
        }
        else
            return '-';
    }      
    
    public static function getArrayActiveStatus(): array
    {
        return [
            //MASTER
            self::ACTIVE_STATUS_YES  => Yii::t('app', 'Yes'),
            self::ACTIVE_STATUS_NO   => Yii::t('app', 'No'),
        ];
    }    
    
    public static function getOneActiveStatus($_module = null): string
    {
        if($_module)
        {
            $arrayModule = self::getArrayActiveStatus();

            switch ($_module) {
                case ($_module == self::ACTIVE_STATUS_YES):
                    $returnValue = LabelHelper::getYes($arrayModule[$_module]);
                    break;
                case ($_module == self::ACTIVE_STATUS_NO):
                    $returnValue = LabelHelper::getNo($arrayModule[$_module]);
                    break;
                default:
                    $returnValue = LabelHelper::getDefault('-');
            }            

            return $returnValue;
        }
        else
            return '-';
    }

    private function getPath() : string {
        $officeUniqueId = CacheService::getInstance()->getOfficeUniqueId();
        return '/uploads/staff/'.$officeUniqueId;
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
    public function getAssetUrl(): string
    {
        return AssetUseCase::getUrl($this->getPath(), $this->file_name);
    }    
    
    /**
    * Process upload of image
    *
    * @return mixed the uploaded image instance
    */
    public function uploadAsset() {
        // get the uploaded file instance. for multiple file uploads
        // the following data will return an array (you may need to use
        // getInstances method)
        $asset = UploadedFile::getInstance($this, 'image');

        // if no image was uploaded abort the upload
        if (empty($asset)) {
            return false;
        }

        // store the source file name
        if($this->title==''){
            $this->title = $asset->name;
        }
        
        // generate a unique file name
        //$ext = end((explode(".", $asset->name)));
        $tmp = explode('.', $asset->name);
        $ext = end($tmp);  
        $this->file_name = Yii::$app->security->generateRandomString().".{$ext}";

        // the uploaded image instance
        return $asset;
    }

    /**
     * Process deletion of image
     *
     * @return boolean the status of deletion
     * @throws Exception
     */
    public function deleteAsset(): bool
    {
        $file = $this->getAssetFile();

        if(AssetUseCase::deleteFile($file)){
            $this->file_name = null;
            return true;
        }
        else{
            return false;
        }
    }          
    
    public function getUrl(): string
    {
        return Yii::$app->getUrlManager()->createUrl(['staff/view', 'id' => $this->id, 'title' => $this->title]);
    }
    
    public static function getName($id){
        $model = Staff::find()->where(['id'=>$id])->one();
        return $model->title;
    }      
}
