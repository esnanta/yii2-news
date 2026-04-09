<?php

namespace common\models;

use common\models\base\Author as BaseAuthor;
use trntv\filekit\behaviors\UploadBehavior;

/**
 * This is the model class for table "t_author".
 */
class Author extends BaseAuthor
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
        return array_replace_recursive(
            parent::rules(),
            [
                [['image'], 'safe'],
                [['office_id', 'user_id', 'size', 'created_by', 'updated_by',
                    'is_deleted', 'deleted_by', 'verlock'], 'integer'],
                [['address', 'description'], 'string'],
                [['created_at', 'updated_at', 'deleted_at'], 'safe'],
                [['title', 'email'], 'string', 'max' => 100],
                [['phone_number'], 'string', 'max' => 50],
                [['base_url', 'path', 'name', 'type'], 'string', 'max' => 255],
                [['uuid'], 'string', 'max' => 36],
                [['verlock'], 'default', 'value' => '0'],
                [['verlock'], 'mootensai\components\OptimisticLockValidator'],
            ]
        );
    }
}
