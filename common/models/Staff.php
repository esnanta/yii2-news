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
     */
    public array|string|null $image;

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
                [['office_id', 'user_id', 'employment_id',
                    'gender_status', 'active_status', 'size',
                    'created_by', 'updated_by', 'is_deleted',
                    'deleted_by', 'verlock'], 'integer'],
                [['initial'], 'required'],
                [['address', 'description'], 'string'],
                [['created_at', 'updated_at', 'deleted_at'], 'safe'],
                [['title', 'identity_number', 'email',
                    'google_plus', 'instagram', 'facebook',
                    'twitter'], 'string', 'max' => 100],
                [['initial'], 'string', 'max' => 10],
                [['phone_number'], 'string', 'max' => 50],
                [['base_url', 'path', 'name', 'type'], 'string', 'max' => 255],
                [['uuid'], 'string', 'max' => 36],
                [['verlock'], 'default', 'value' => '0'],
                [['verlock'], 'mootensai\components\OptimisticLockValidator'],
            ]
        );
    }
}
