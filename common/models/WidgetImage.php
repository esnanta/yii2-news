<?php

namespace common\models;

use common\behaviors\CacheInvalidateBehavior;
use trntv\filekit\behaviors\UploadBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "widget_image".
 *
 * @property int         $id
 * @property string      $key
 * @property null|string $title
 * @property null|string $base_url
 * @property null|string $path
 * @property null|string $mime_type
 * @property null|int    $size
 * @property null|string $link_url
 * @property null|string $alt_text
 * @property null|string $created_at
 * @property null|string $updated_at
 * @property null|array  $image
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
            [['size', 'created_at', 'updated_at'], 'integer'],
            [['key', 'title', 'mime_type'], 'string', 'max' => 100],
            [['alt_text'], 'string', 'max' => 255],
            [['base_url', 'path'], 'string', 'max' => 1024],
            [['link_url'], 'string', 'max' => 500],
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
            'mime_type' => \Yii::t('common', 'Mime Type'),
            'size' => \Yii::t('common', 'Size'),
            'link_url' => \Yii::t('common', 'Link Url'),
            'alt_text' => \Yii::t('common', 'Alt Text'),
            'created_at' => \Yii::t('common', 'Created At'),
            'updated_at' => \Yii::t('common', 'Updated At'),
        ];
    }
}
