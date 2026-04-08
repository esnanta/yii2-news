<?php

namespace common\models\base;

use common\base\BaseActiveRecord;
use common\models\Article;
use common\models\query\ArticleCategoryQuery;
use mootensai\behaviors\UUIDBehavior;
use mootensai\relation\RelationTrait;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * This is the base model class for table "t_article_category".
 *
 * @property int               $id
 * @property string            $slug
 * @property string            $title
 * @property string            $body
 * @property int               $parent_id
 * @property int               $status
 * @property string            $created_at
 * @property string            $updated_at
 * @property int               $created_by
 * @property int               $updated_by
 * @property int               $is_deleted
 * @property string            $deleted_at
 * @property int               $deleted_by
 * @property int               $verlock
 * @property string            $uuid
 * @property Article[]         $articles
 * @property ArticleCategory   $parent
 * @property ArticleCategory[] $articleCategories
 */
class ArticleCategory extends BaseActiveRecord
{
    use RelationTrait;

    private $_rt_softdelete;
    private $_rt_softrestore;

    public function __construct()
    {
        parent::__construct();
        $this->_rt_softdelete = [
            'deleted_by' => \Yii::$app->user->id,
            'deleted_at' => date('Y-m-d H:i:s'),
        ];
        $this->_rt_softrestore = [
            'deleted_by' => 0,
            'deleted_at' => date('Y-m-d H:i:s'),
        ];
    }

    /**
     * This function helps \mootensai\relation\RelationTrait runs faster.
     *
     * @return array relation names of this model
     */
    public function relationNames(): array
    {
        return [
            'articles',
            'parent',
            'articleCategories',
        ];
    }

    public function rules(): array
    {
        return [
            [['slug', 'title'], 'required'],
            [['body'], 'string'],
            [['parent_id', 'status', 'created_by', 'updated_by', 'is_deleted', 'deleted_by', 'verlock'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['slug'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 512],
            [['uuid'], 'string', 'max' => 36],
            [['slug'], 'unique'],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator'],
        ];
    }

    public static function tableName(): string
    {
        return 't_article_category';
    }

    /**
     * @return string
     *                overwrite function optimisticLock
     *                return string name of field are used to stored optimistic lock
     */
    public function optimisticLock(): string
    {
        return 'verlock';
    }

    public function attributeLabels(): array
    {
        return [
            'id' => \Yii::t('common', 'ID'),
            'slug' => \Yii::t('common', 'Slug'),
            'title' => \Yii::t('common', 'Title'),
            'body' => \Yii::t('common', 'Body'),
            'parent_id' => \Yii::t('common', 'Parent ID'),
            'status' => \Yii::t('common', 'Status'),
            'is_deleted' => \Yii::t('common', 'Is Deleted'),
            'verlock' => \Yii::t('common', 'Verlock'),
            'uuid' => \Yii::t('common', 'Uuid'),
        ];
    }

    public function getArticles(): ActiveQuery
    {
        return $this->hasMany(Article::class, ['category_id' => 'id']);
    }

    public function getParent(): ActiveQuery
    {
        return $this->hasOne(ArticleCategory::class, ['id' => 'parent_id']);
    }

    public function getArticleCategories(): ActiveQuery
    {
        return $this->hasMany(ArticleCategory::class, ['parent_id' => 'id']);
    }

    /**
     * @return array mixed
     */
    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => date('Y-m-d H:i:s'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            'uuid' => [
                'class' => UUIDBehavior::class,
                'column' => 'uuid',
            ],
        ];
    }

    /**
     * The following code shows how to apply a default condition for all queries:
     *
     * ```php
     * class Customer extends ActiveRecord
     * {
     *     public static function find()
     *     {
     *         return parent::find()->where(['deleted' => false]);
     *     }
     * }
     *
     * // Use andWhere()/orWhere() to apply the default condition
     * // SELECT FROM customer WHERE `deleted`=:deleted AND age>30
     * $customers = Customer::find()->andWhere('age>30')->all();
     *
     * // Use where() to ignore the default condition
     * // SELECT FROM customer WHERE age>30
     * $customers = Customer::find()->where('age>30')->all();
     * ```
     */

    /**
     * @return ArticleCategoryQuery the active query used by this AR class
     */
    public static function find(): ArticleCategoryQuery
    {
        $query = new ArticleCategoryQuery(get_called_class());

        return $query->where(['t_article_category.deleted_by' => 0]);
    }
}
