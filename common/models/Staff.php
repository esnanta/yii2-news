<?php

namespace common\models;

use common\models\base\Staff as BaseStaff;
use common\models\query\StaffQuery;
use trntv\filekit\behaviors\UploadBehavior;

/**
 * This is the model class for table "t_staff".
 *
 * @property string $url
 */
class Staff extends BaseStaff
{
    public const STATUS_ACTIVE = 1;
    public const STATUS_NOT_ACTIVE = 2;

    public const GENDER_MALE = 1;
    public const GENDER_FEMALE = 2;

    /**
     * Virtual attribute used by filekit upload widget.
     */
    public array|string|null $image = null;

    /**
     * @return array statuses list
     */
    public static function statuses(): array
    {
        return [
            self::STATUS_NOT_ACTIVE => \Yii::t('common', 'Not Active'),
            self::STATUS_ACTIVE => \Yii::t('common', 'Active'),
        ];
    }

    /**
     * @return array gender list
     */
    public static function genders(): array
    {
        return [
            self::GENDER_MALE => \Yii::t('common', 'Male'),
            self::GENDER_FEMALE => \Yii::t('common', 'Female'),
        ];
    }

    public function behaviors(): array
    {
        return array_merge(parent::behaviors(), [
            'photoUpload' => [
                'class' => UploadBehavior::class,
                'attribute' => 'image',
                'pathAttribute' => 'path',
                'baseUrlAttribute' => 'base_url',
                'typeAttribute' => 'type',
                'sizeAttribute' => 'size',
                'nameAttribute' => 'name',
            ],
        ]);
    }

    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                [['image'], 'safe'],
                [['office_id', 'employment_id', 'gender', 'status', 'size',
                    'created_by', 'updated_by', 'is_deleted',
                    'deleted_by', 'verlock'], 'integer'],
                [['initial'], 'required'],
                [['address', 'description'], 'string'],
                [['created_at', 'updated_at', 'deleted_at'], 'safe'],
                [['title', 'identity_number', 'email'], 'string', 'max' => 100],
                [['initial'], 'string', 'max' => 10],
                [['phone_number'], 'string', 'max' => 50],
                [['base_url', 'path', 'name', 'type'], 'string', 'max' => 255],
                [['uuid'], 'string', 'max' => 36],
                [['verlock'], 'default', 'value' => '0'],
                [['verlock'], 'mootensai\components\OptimisticLockValidator'],
            ]
        );
    }

    public function attributeLabels(): array
    {
        return [
            'id' => \Yii::t('common', 'ID'),
            'office_id' => \Yii::t('common', 'Office'),
            'employment_id' => \Yii::t('common', 'JobTitle'),
            'title' => \Yii::t('common', 'Title'),
            'initial' => \Yii::t('common', 'Initial'),
            'identity_number' => \Yii::t('common', 'Identity Number'),
            'phone_number' => \Yii::t('common', 'Phone Number'),
            'gender' => \Yii::t('common', 'Gender'),
            'active' => \Yii::t('common', 'Active'),
            'address' => \Yii::t('common', 'Address'),
            'base_url' => \Yii::t('common', 'Base Url'),
            'path' => \Yii::t('common', 'Path'),
            'name' => \Yii::t('common', 'Name'),
            'type' => \Yii::t('common', 'Type'),
            'size' => \Yii::t('common', 'Size'),
            'email' => \Yii::t('common', 'Email'),
            'description' => \Yii::t('common', 'Description'),
            'is_deleted' => \Yii::t('common', 'Is Deleted'),
            'verlock' => \Yii::t('common', 'Verlock'),
            'uuid' => \Yii::t('common', 'Uuid'),
        ];
    }

    public function getUrl()
    {
        return $this->base_url.'/'.$this->path;
    }

    /**
     * @return StaffQuery the active query used by this AR class
     */
    public static function find(): StaffQuery
    {
        $query = new StaffQuery(get_called_class());

        return $query->where(['t_staff.is_deleted' => 0]);
    }
}
