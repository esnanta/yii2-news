<?php

namespace common\models;

use common\behaviors\CacheInvalidateBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "widget_carousel".
 *
 * @property int                  $id
 * @property string               $key
 * @property int                  $status
 * @property WidgetCarouselItem[] $items
 */
class WidgetCarousel extends ActiveRecord
{
    public const STATUS_DRAFT = 0;
    public const STATUS_ACTIVE = 1;

    public static function tableName()
    {
        return '{{%widget_carousel}}';
    }

    /**
     * @return array statuses list
     */
    public static function statuses()
    {
        return [
            self::STATUS_DRAFT => \Yii::t('common', 'Draft'),
            self::STATUS_ACTIVE => \Yii::t('common', 'Active'),
        ];
    }

    public function behaviors()
    {
        return [
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
            [['status'], 'integer'],
            [['key'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('common', 'ID'),
            'key' => \Yii::t('common', 'Key'),
            'status' => \Yii::t('common', 'Active'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(WidgetCarouselItem::class, ['carousel_id' => 'id']);
    }
}
