<?php

namespace common\models;

use trntv\filekit\behaviors\UploadBehavior;
use \common\models\base\Author as BaseAuthor;

/**
 * This is the model class for table "t_author".
 */
class Author extends BaseAuthor
{
    /**
     * Virtual attribute used by filekit upload widget.
     *
     * @var array|string|null
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

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(
            parent::rules(),
            [
                [['office_id', 'user_id', 'photo_size', 'created_by', 'updated_by', 'is_deleted', 'deleted_by', 'verlock'], 'integer'],
                [['address', 'description'], 'string'],
                [['created_at', 'updated_at', 'deleted_at'], 'safe'],
                [['title', 'email'], 'string', 'max' => 100],
                [['photo_base_url', 'photo_path', 'photo_name', 'photo_type'], 'string', 'max' => 255],
                [['image'], 'safe'],
                [['phone_number'], 'string', 'max' => 50],
                [['uuid'], 'string', 'max' => 36],
                [['verlock'], 'default', 'value' => '0'],
                [['verlock'], 'mootensai\components\OptimisticLockValidator'],
            ]
        );
    }

}
