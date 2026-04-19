<?php

namespace common\models;

use common\behaviors\CacheInvalidateBehavior;
use trntv\filekit\behaviors\UploadBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "widget_carousel_item".
 *
 * @property int            $id
 * @property int            $carousel_id
 * @property string         $base_url
 * @property string         $path
 * @property string         $asset_url
 * @property string         $type
 * @property string         $image
 * @property string         $url
 * @property string         $caption
 * @property int            $status
 * @property int            $order
 * @property WidgetCarousel $carousel
 * @property string         $assetUrl
 */
class WidgetCarouselItem extends ActiveRecord
{
    /**
     * @var null|array
     */
    public $image;

    public static function tableName()
    {
        return '{{%widget_carousel_item}}';
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $key = array_search('carousel_id', $scenarios[self::SCENARIO_DEFAULT], true);
        $scenarios[self::SCENARIO_DEFAULT][$key] = '!carousel_id';

        return $scenarios;
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => UploadBehavior::class,
                'attribute' => 'image',
                'pathAttribute' => 'path',
                'baseUrlAttribute' => 'base_url',
                'typeAttribute' => 'type',
            ],
            'cacheInvalidate' => [
                'class' => CacheInvalidateBehavior::class,
                'cacheComponent' => 'frontendCache',
                'keys' => [
                    function ($model) {
                        return [
                            WidgetCarousel::class,
                            $model->carousel->key,
                        ];
                    },
                ],
            ],
        ];
    }

    public function rules()
    {
        return [
            [['carousel_id'], 'required'],
            [['carousel_id', 'status', 'order'], 'integer'],
            [['url', 'caption', 'base_url', 'path'], 'string', 'max' => 1024],
            [['type'], 'string', 'max' => 255],
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
            'carousel_id' => \Yii::t('common', 'Carousel ID'),
            'image' => \Yii::t('common', 'Image'),
            'base_url' => \Yii::t('common', 'Base URL'),
            'path' => \Yii::t('common', 'Path'),
            'type' => \Yii::t('common', 'File Type'),
            'url' => \Yii::t('common', 'Url'),
            'caption' => \Yii::t('common', 'Caption'),
            'status' => \Yii::t('common', 'Active'),
            'order' => \Yii::t('common', 'Order'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCarousel()
    {
        return $this->hasOne(WidgetCarousel::class, ['id' => 'carousel_id']);
    }
}
