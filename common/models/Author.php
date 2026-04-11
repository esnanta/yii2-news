<?php

namespace common\models;

use common\models\base\Author as BaseAuthor;
use common\models\query\AuthorQuery;
use trntv\filekit\behaviors\UploadBehavior;

/**
 * This is the model class for table "t_author".
 *
 * @property mixed  $publicIdentity
 * @property string $url
 */
class Author extends BaseAuthor
{
    /**
     * Virtual attribute used by filekit upload widget.
     */
    public array|string|null $image = null;

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
                [['office_id', 'size', 'created_by', 'updated_by',
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

    public function attributeLabels(): array
    {
        return [
            'id' => \Yii::t('common', 'ID'),
            'office_id' => \Yii::t('common', 'Office'),
            'title' => \Yii::t('common', 'Title'),
            'phone_number' => \Yii::t('common', 'Phone Number'),
            'email' => \Yii::t('common', 'Email'),
            'base_url' => \Yii::t('common', 'Base Url'),
            'path' => \Yii::t('common', 'Path'),
            'name' => \Yii::t('common', 'Name'),
            'type' => \Yii::t('common', 'Type'),
            'size' => \Yii::t('common', 'Size'),
            'address' => \Yii::t('common', 'Address'),
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
     * @return AuthorQuery the active query used by this AR class
     */
    public static function find(): AuthorQuery
    {
        $query = new AuthorQuery(get_called_class());

        return $query->where(['t_author.is_deleted' => 0]);
    }

    public function getPublicIdentity(): string
    {
        if ($this->title) {
            return $this->title;
        }

        return $this->email;
    }
}
