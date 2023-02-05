<?php

namespace backend\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

use \backend\models\base\Staff as BaseStaff;

class Staff extends BaseStaff
{
    
    const GENDER_MALE           = 1;
    const GENDER_FEMALE         = 2;       
    
    const ACTIVE_STATUS_YES     = 1;
    const ACTIVE_STATUS_NO      = 2;
    
    public $image;
    public static $path='/uploads/staff';    
      
    /**
     * @inheritdoc
     */   
    public function rules()
    {
        return [
            //TAMBAHAN
            [['image'], 'file', 'extensions'=>'jpg, gif, png, jpeg','maxSize' => (500 * 1024), 'tooBig' => 'Limit is 500KB'],                        
            
            [['employment_id', 'gender_status', 'active_status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['address', 'description'], 'string'],
            [['title', 'identity_number', 'email', 'google_plus', 'instagram', 'facebook', 'twitter'], 'string', 'max' => 100],
            [['initial'], 'string', 'max' => 10],
            [['phone_number'], 'string', 'max' => 50],
            [['file_name'], 'string', 'max' => 200],
            [['verlock', 'is_deleted'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']         
        ];        
    }    
    
    public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->isNewRecord) {       
            $this->active_status    = self::ACTIVE_STATUS_YES;
        }

        $this->twitter      = str_replace('@', '', $this->twitter);
        $this->instagram    = str_replace('@', '', $this->instagram);
        $this->facebook     = str_replace('@', '', $this->facebook);
        $this->google_plus  = str_replace('@', '', $this->google_plus);
        $this->email        = str_replace('@', '', $this->email);
        
        return true;
    }        
    
    public static function getArrayGenderStatus()
    {
        return [
            //MASTER
            self::GENDER_MALE       => 'Laki-laki',
            self::GENDER_FEMALE     => 'Perempuan', 
        ];
    }    
    
    public static function getOneGenderStatus($_module = null)
    {
        if($_module)
        {
            $arrayModule = self::getArrayGenderStatus();
            $returnValue = 'Unset';
            
            switch ($_module) {
                case ($_module == self::GENDER_MALE):
                    $returnValue = '<span class="label label-primary">'.$arrayModule[$_module].'</span>';
                    break;
                case ($_module == self::GENDER_FEMALE):
                    $returnValue = '<span class="label label-info">'.$arrayModule[$_module].'</span>';
                    break;
                default:
                    $returnValue = '<span class="label label-default">'.$returnValue.'</span>';
            }                 
            
            return $returnValue;
        }
        else
            return;
    }      
    
    public static function getArrayActiveStatus()
    {
        return [
            //MASTER
            self::ACTIVE_STATUS_YES  => 'Yes',
            self::ACTIVE_STATUS_NO   => 'No', 
        ];
    }    
    
    public static function getOneActiveStatus($_module = null)
    {
        if($_module)
        {
            $arrayModule = self::getArrayActiveStatus();
            $returnValue = 'Unset';

            switch ($_module) {
                case ($_module == self::ACTIVE_STATUS_YES):
                    $returnValue = '<span class="label label-primary">'.$arrayModule[$_module].'</span>';
                    break;
                case ($_module == self::ACTIVE_STATUS_NO):
                    $returnValue = '<span class="label label-danger">'.$arrayModule[$_module].'</span>';
                    break;
                default:
                    $returnValue = '<span class="label label-default">'.$returnValue.'</span>';
            }            

            return $returnValue;
        }
        else
            return;
    }       
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                => 'ID',
            'employment_id'     => Yii::$app->params['Attribute_Employment'],
            'title'             => Yii::$app->params['Attribute_Title'],
            'identity_number'   => Yii::$app->params['Attribute_IdentityNumber'],
            'initial'           => Yii::$app->params['Attribute_Initial'],
            'phone_number'      => Yii::$app->params['Attribute_PhoneNumber'],
            'gender_status'     => Yii::$app->params['Attribute_GenderStatus'],
            'address'           => Yii::$app->params['Attribute_Address'],
            'file_name'         => 'File Name',
            'email'             => 'Email',
            'google_plus'       => 'Google Plus',
            'instagram'         => 'Instagram',
            'facebook'          => 'Facebook',
            'twitter'           => 'Twitter',
            
            'active_status'     => 'Active',         
            
            'created_at'        => Yii::$app->params['Attribute_CreatedAt'],
            'updated_at'        => Yii::$app->params['Attribute_UpdatedAt'],
            'created_by'        => Yii::$app->params['Attribute_CreatedBy'],
            'updated_by'        => Yii::$app->params['Attribute_UpdatedBy'],
            
            'is_deleted'        => 'Deleted',
            'deleted_at'        => Yii::$app->params['Attribute_DeletedAt'],
            'deleted_by'        => Yii::$app->params['Attribute_DeletedBy'],
            
            'verlock'           => 'Verlock',
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
        $file_name = isset($this->file_name) ? self::$path.'/'.$this->file_name : '/images/'.'if_skype2512x512_197582.png';
        return Yii::$app->urlManager->baseUrl . $file_name;        
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
    
    public function getUrl()
    {
        return Yii::$app->getUrlManager()->createUrl(['staff/view', 'id' => $this->id, 'title' => $this->title]);
    }    
    
    //https://code.tutsplus.com/tutorials/how-to-program-with-yii2-timestamp-behavior--cms-23329    
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
    
    public static function getName($id){
        $model = Staff::find()->where(['id'=>$id])->one();
        return $model->title;
    }      
}
