<?php

namespace common\models;

use common\models\base\Staff as BaseStaff;
use trntv\filekit\behaviors\UploadBehavior;

/**
 * This is the model class for table "t_staff".
 */
class Staff extends BaseStaff
{
    /**
     * Virtual attribute used by filekit upload widget.
     *
     * @var null|array|string
     */
    public $image;

    public function behaviors(): array
    {
        return array_merge(parent::behaviors(), [
            'photoUpload' => [
                'class' => UploadBehavior::class,
                'attribute' => 'image',
                'pathAttribute' => 'photo_path',
                'baseUrlAttribute' => 'photo_base_url',
                'typeAttribute' => 'photo_type',
                'sizeAttribute' => 'photo_size',
                'nameAttribute' => 'photo_name',
            ],
        ]);
    }

    public function rules(): array
    {
        return array_replace_recursive(
            parent::rules(),
            [
                [['office_id', 'user_id', 'employment_id', 'gender_status',
                    'active_status', 'photo_size', 'created_by', 'updated_by',
                    'is_deleted', 'deleted_by', 'verlock'], 'integer'],
                [['initial'], 'required'],
                [['address', 'description'], 'string'],
                [['created_at', 'updated_at', 'deleted_at'], 'safe'],
                [['title', 'identity_number', 'email', 'google_plus',
                    'instagram', 'facebook', 'twitter'], 'string', 'max' => 100],
                [['initial'], 'string', 'max' => 10],
                [['phone_number'], 'string', 'max' => 50],
                [['photo_base_url', 'photo_path', 'photo_name', 'photo_type'], 'string', 'max' => 255],
                [['image'], 'safe'],
                [['uuid'], 'string', 'max' => 36],
                [['verlock'], 'default', 'value' => '0'],
                [['verlock'], 'mootensai\components\OptimisticLockValidator'],
            ]
        );
    }
}
