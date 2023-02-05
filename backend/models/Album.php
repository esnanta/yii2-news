<?php

namespace backend\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use \backend\models\base\Album as BaseAlbum;

/**
 * This is the model class for table "tx_album".
 */
class Album extends BaseAlbum
{
    public static $path='/uploads/photo';

    const ALBUM_TYPE_PRIVATE    = 1;//4
    const ALBUM_TYPE_PUBLIC     = 2;//5

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['album_type', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['description'], 'string'],
            [['cover'], 'string', 'max' => 500],
            [['title'], 'string', 'max' => 200],
            [['title'], 'unique'],
            [['verlock', 'is_deleted'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }

    public static function getArrayAlbumType()
    {
        return [
            //MASTER
            self::ALBUM_TYPE_PRIVATE    => 'Private',
            self::ALBUM_TYPE_PUBLIC     => 'Public',
        ];
    }

    public static function getOneAlbumType($_module = null)
    {
        if($_module)
        {
            $arrayModule = self::getArrayAlbumType();
            $returnValue = 'NULL';

            switch ($_module) {
                case ($_module == self::ALBUM_TYPE_PRIVATE):
                    $returnValue = '<span class="label label-default">'.$arrayModule[$_module].'</span>';
                    break;
                case ($_module == self::ALBUM_TYPE_PUBLIC):
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

    /**
     *
     */
    public function getUrl()
    {
        return Yii::$app->getUrlManager()->createUrl(['album/view', 'id' => $this->id, 'title' => $this->title]);
    }

    /**
     * fetch stored image url
     * @return string
     */
    public function getImageUrl()
    {
        // return a default image placeholder if your source avatar is not found
        $defaultImage = '/images/default_user.jpg';
        $file_name = isset($this->cover) ? $this->cover : $defaultImage;
        $directory = str_replace('frontend', 'backend', Yii::getAlias('@webroot')) . self::$path;

        if (file_exists($directory.'/'.$file_name)) {
            return Yii::$app->urlManager->baseUrl . self::$path.'/'.$file_name;
        }
        else{
            return Yii::$app->urlManager->baseUrl . $defaultImage;
        }
    }

    public function getPhotosCount()
    {
        return $this->hasMany(Photo::className(), ['album_id' => 'id'])->count('id');
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
