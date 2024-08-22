<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
/**
 * This is the model class for table "tx_profile".
 *
 * @property integer $user_id
 * @property string $name
 * @property string $public_email
 * @property string $gravatar_email
 * @property string $gravatar_id
 * @property string $location
 * @property string $website
 * @property string $timezone
 * @property string $bio
 * @property string $file_name
 *
 * @property User $user
 */
class Profile extends \common\models\base\Profile
{
    public $email;
    public $username;
    public $password;

    public static $path='/uploads/profile';

    public function rules()
    {
        return [

            //TIDAK PERLU TAMBAHAN
            //PENGATURAN FILE MENYEBABKAN ERROR UNTUK KASUS CROPPING
            //[['file_name'], 'file', 'extensions'=>'jpg, gif, png, jpeg','maxSize' => (1024 * 1024 * 1), 'tooBig' => 'Limit is 1Mb'],

            [['bio'], 'string'],
            [['name', 'public_email', 'gravatar_email', 'location', 'website'], 'string', 'max' => 255],
            [['gravatar_id'], 'string', 'max' => 32],
            [['timezone'], 'string', 'max' => 40],
            [['file_name'], 'string', 'max' => 200],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
        //$file_name = 'no_image.jpg';
        $file_name = isset($this->file_name) ? $this->file_name : 'no_image.jpg';
        return Yii::$app->urlManager->baseUrl .self::$path.'/'. $file_name;
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

        // store the source file
        // $this->title aslinya
        if($this->name==''){
            $this->name = $image->name;
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

        return true;
    }
}
