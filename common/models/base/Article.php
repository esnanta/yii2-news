<?php

namespace common\models\base;

use Yii;
use common\base\BaseActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;
use yii\db\ActiveQuery;
use mootensai\relation\RelationTrait;
use common\models\query\ArticleQuery;
use common\models\ArticleAttachment;
use common\models\ArticleCategory;
use common\models\Author;
use common\models\User;

/**
 * This is the base model class for table "t_article".
 *
 * @property integer $id
 * @property integer $author_id
 * @property string $slug
 * @property string $title
 * @property string $body
 * @property string $view
 * @property integer $category_id
 * @property string $thumbnail_base_url
 * @property string $thumbnail_path
 * @property integer $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $created_at
 * @property string $updated_at
 * @property string $published_at
 * @property integer $is_deleted
 * @property string $deleted_at
 * @property integer $deleted_by
 * @property integer $verlock
 * @property string $uuid
 *
 * @property Author $author
 * @property User $createdBy
 * @property ArticleCategory $category
 * @property User $updatedBy
 * @property ArticleAttachment[] $articleAttachments
 */
class Article extends BaseActiveRecord
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
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames(): array
    {
        return [
            'author',
            'createdBy',
            'category',
            'updatedBy',
            'articleAttachments'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['author_id', 'category_id', 'status', 'created_by', 'updated_by', 'is_deleted', 'deleted_by', 'verlock'], 'integer'],
            [['slug', 'title', 'body'], 'required'],
            [['body'], 'string'],
            [['created_at', 'updated_at', 'published_at', 'deleted_at'], 'safe'],
            [['slug', 'view'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 512],
            [['thumbnail_base_url', 'thumbnail_path'], 'string', 'max' => 1024],
            [['uuid'], 'string', 'max' => 36],
            [['slug'], 'unique'],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 't_article';
    }

    /**
     *
     * @return string
     * overwrite function optimisticLock
     * return string name of field are used to stored optimistic lock
     *
     */
    public function optimisticLock(): string
    {
        return 'verlock';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'author_id' => Yii::t('common', 'Author ID'),
            'slug' => Yii::t('common', 'Slug'),
            'title' => Yii::t('common', 'Title'),
            'body' => Yii::t('common', 'Body'),
            'view' => Yii::t('common', 'View'),
            'category_id' => Yii::t('common', 'Category ID'),
            'thumbnail_base_url' => Yii::t('common', 'Thumbnail Base Url'),
            'thumbnail_path' => Yii::t('common', 'Thumbnail Path'),
            'status' => Yii::t('common', 'Status'),
            'published_at' => Yii::t('common', 'Published At'),
            'is_deleted' => Yii::t('common', 'Is Deleted'),
            'verlock' => Yii::t('common', 'Verlock'),
            'uuid' => Yii::t('common', 'Uuid'),
        ];
    }
    
    /**
     * @return ActiveQuery
     */
    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }
        
    /**
     * @return ActiveQuery
     */
    public function getCreatedBy(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }
        
    /**
     * @return ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(ArticleCategory::class, ['id' => 'category_id']);
    }
        
    /**
     * @return ActiveQuery
     */
    public function getUpdatedBy(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }
        
    /**
     * @return ActiveQuery
     */
    public function getArticleAttachments(): ActiveQuery
    {
        return $this->hasMany(ArticleAttachment::class, ['article_id' => 'id']);
    }
    
    /**
     * @inheritdoc
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
     * @inheritdoc
     * @return ArticleQuery the active query used by this AR class.
     */
    public static function find(): ArticleQuery
    {
        $query = new ArticleQuery(get_called_class());
        return $query->where(['t_article.deleted_by' => 0]);
    }
}
