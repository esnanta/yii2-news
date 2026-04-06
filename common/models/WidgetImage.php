<?php

namespace common\models;

use common\behaviors\CacheInvalidateBehavior;
use trntv\filekit\behaviors\UploadBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "widget_image".
 *
 * @property int             $id
 * @property string          $key
 * @property null|string     $title
 * @property null|string     $base_url
 * @property null|string     $path
 * @property null|string     $asset_url
 * @property null|string     $mime_type
 * @property null|int        $size
 * @property null|string     $link_url
 * @property null|string     $alt_text
 * @property null|int        $sequence
 * @property null|string     $created_at
 * @property null|string     $updated_at
 * @property null|int        $created_by
 * @property null|int        $updated_by
 * @property null|int        $is_deleted
 * @property null|string     $deleted_at
 * @property null|int        $deleted_by
 * @property null|int|string $verlock
 * @property null|string     $uuid
 * @property null|array      $image
 */
class WidgetImage extends ActiveRecord
{
    /**
     * @var null|array
     */
    public $image;

    public static function tableName()
    {
        return '{{%widget_image}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => UploadBehavior::class,
                'attribute' => 'image',
                'pathAttribute' => 'path',
                'baseUrlAttribute' => 'base_url',
                'typeAttribute' => 'mime_type',
                'sizeAttribute' => 'size',
            ],
            'cacheInvalidate' => [
                'class' => CacheInvalidateBehavior::class,
                'cacheComponent' => 'frontendCache',
                'keys' => [
                    function ($model) {
                        return [
                            self::class,
                            $model->key,
                        ];
                    },
                ],
            ],
        ];
    }

    public function rules()
    {
        return [
            [['key'], 'required'],
            [['key'], 'unique'],
            [['size', 'sequence', 'created_by', 'updated_by', 'is_deleted', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['key', 'title', 'mime_type', 'uuid'], 'string', 'max' => 100],
            [['alt_text'], 'string', 'max' => 255],
            [['base_url', 'path', 'asset_url'], 'string', 'max' => 1024],
            [['link_url'], 'string', 'max' => 500],
            [['verlock'], 'number'],
            ['image', 'required', 'when' => function ($model) {
                return $model->getIsNewRecord();
            }],
            ['image', 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('common', 'ID'),
            'key' => \Yii::t('common', 'Key'),
            'title' => \Yii::t('common', 'Title'),
            'image' => \Yii::t('common', 'Image'),
            'base_url' => \Yii::t('common', 'Base Url'),
            'path' => \Yii::t('common', 'Path'),
            'asset_url' => \Yii::t('common', 'Asset Url'),
            'mime_type' => \Yii::t('common', 'Mime Type'),
            'size' => \Yii::t('common', 'Size'),
            'link_url' => \Yii::t('common', 'Link Url'),
            'alt_text' => \Yii::t('common', 'Alt Text'),
            'sequence' => \Yii::t('common', 'Sequence'),
            'created_at' => \Yii::t('common', 'Created At'),
            'updated_at' => \Yii::t('common', 'Updated At'),
            'created_by' => \Yii::t('common', 'Created By'),
            'updated_by' => \Yii::t('common', 'Updated By'),
            'is_deleted' => \Yii::t('common', 'Is Deleted'),
            'deleted_at' => \Yii::t('common', 'Deleted At'),
            'deleted_by' => \Yii::t('common', 'Deleted By'),
            'verlock' => \Yii::t('common', 'Verlock'),
            'uuid' => \Yii::t('common', 'Uuid'),
        ];
    }
}
