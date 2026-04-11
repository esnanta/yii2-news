<?php

namespace common\models;

use common\models\base\ArticleCategory as BaseArticleCategory;
use common\models\query\ArticleCategoryQuery;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "t_article_category".
 *
 * @property int             $id
 * @property string          $slug
 * @property string          $title
 * @property string          $body
 * @property null|int        $parent_id
 * @property null|int        $status
 * @property null|string     $created_at
 * @property null|string     $updated_at
 * @property null|int        $created_by
 * @property null|int        $updated_by
 * @property null|int        $is_deleted
 * @property null|string     $deleted_at
 * @property null|int        $deleted_by
 * @property null|int        $verlock
 * @property null|string     $uuid
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
        $behaviors = parent::behaviors();
        $behaviors['slug'] = [
            'class' => SluggableBehavior::class,
            'attribute' => 'title',
            'immutable' => true,
        ];

        return $behaviors;
    }

    public function rules(): array
    {
        return array_merge(parent::rules(), [
            ['parent_id', 'exist',
                'skipOnError' => true,
                'targetClass' => self::class,
                'targetAttribute' => ['parent_id' => 'id']],
        ]);
    }

    public function attributeLabels(): array
    {
        return array_merge(parent::attributeLabels(), [
            'parent_id' => \Yii::t('common', 'Parent Category'),
            'status' => \Yii::t('common', 'Status'),
        ]);
    }

    /**
     * @return ArticleCategoryQuery the active query used by this AR class
     */
    public static function find(): ArticleCategoryQuery
    {
        $query = new ArticleCategoryQuery(get_called_class());

        return $query->where(['t_article_category.is_deleted' => 0]);
    }
}
