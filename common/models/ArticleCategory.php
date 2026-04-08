<?php

namespace common\models;

use common\models\base\ArticleCategory as BaseArticleCategory;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "article_category".
 *
 * @property int             $id
 * @property string          $slug
 * @property string          $title
 * @property int             $status
 * @property Article[]       $articles
 * @property ArticleCategory $parent
 */
class ArticleCategory extends BaseArticleCategory
{
    public const STATUS_ACTIVE = 1;
    public const STATUS_DRAFT = 0;

    /**
     * @return array statuses list
     */
    public static function statuses(): array
    {
        return [
            self::STATUS_DRAFT => \Yii::t('common', 'Draft'),
            self::STATUS_ACTIVE => \Yii::t('common', 'Active'),
        ];
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
                'immutable' => true,
            ],
        ];
    }

    public function rules(): array
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 512],
            [['slug'], 'unique'],
            [['slug'], 'string', 'max' => 255],
            ['status', 'integer'],
            ['parent_id', 'exist', 'targetClass' => ArticleCategory::class, 'targetAttribute' => 'id'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => \Yii::t('common', 'ID'),
            'slug' => \Yii::t('common', 'Slug'),
            'title' => \Yii::t('common', 'Title'),
            'parent_id' => \Yii::t('common', 'Parent Category'),
            'status' => \Yii::t('common', 'Active'),
        ];
    }
}
