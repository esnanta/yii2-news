<?php

namespace common\models\base;

use Yii;
use yii\db\ActiveQuery;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "tx_article".
 *
 * @property integer $id
 * @property integer $office_id
 * @property integer $article_category_id
 * @property integer $author_id
 * @property string $title
 * @property string $cover
 * @property string $url
 * @property string $content
 * @property string $description
 * @property string $tags
 * @property integer $publish_status
 * @property integer $pinned_status
 * @property integer $view_counter
 * @property double $rating
 * @property string $date_issued
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $is_deleted
 * @property string $deleted_at
 * @property integer $deleted_by
 * @property integer $verlock
 * @property string $uuid
 *
 * @property \common\models\Author $author
 * @property \common\models\ArticleCategory $articleCategory
 * @property \common\models\Office $office
 */
class Article extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    private $_rt_softdelete;
    private $_rt_softrestore;

    public function __construct(){
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
            'articleCategory',
            'office'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['office_id', 'article_category_id', 'author_id', 'publish_status', 'pinned_status', 'view_counter', 'created_by', 'updated_by', 'is_deleted', 'deleted_by', 'verlock'], 'integer'],
            [['content', 'description', 'tags'], 'string'],
            [['rating'], 'number'],
            [['date_issued', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['title'], 'string', 'max' => 200],
            [['cover', 'url'], 'string', 'max' => 300],
            [['uuid'], 'string', 'max' => 36],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'tx_article';
    }

    /**
     *
     * @return string
     * overwrite function optimisticLock
     * return string name of field are used to stored optimistic lock
     *
     */
    public function optimisticLock(): string {
        return 'verlock';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'office_id' => Yii::t('app', 'Office ID'),
            'article_category_id' => Yii::t('app', 'Article Category ID'),
            'author_id' => Yii::t('app', 'Author ID'),
            'title' => Yii::t('app', 'Title'),
            'cover' => Yii::t('app', 'Cover'),
            'url' => Yii::t('app', 'Url'),
            'content' => Yii::t('app', 'Content'),
            'description' => Yii::t('app', 'Description'),
            'tags' => Yii::t('app', 'Tags'),
            'publish_status' => Yii::t('app', 'Publish Status'),
            'pinned_status' => Yii::t('app', 'Pinned Status'),
            'view_counter' => Yii::t('app', 'View Counter'),
            'rating' => Yii::t('app', 'Rating'),
            'date_issued' => Yii::t('app', 'Date Issued'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'verlock' => Yii::t('app', 'Verlock'),
            'uuid' => Yii::t('app', 'Uuid'),
        ];
    }
    
    /**
     * @return ActiveQuery
     */
    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(\common\models\Author::className(), ['id' => 'author_id']);
    }
        
    /**
     * @return ActiveQuery
     */
    public function getArticleCategory(): ActiveQuery
    {
        return $this->hasOne(\common\models\ArticleCategory::className(), ['id' => 'article_category_id']);
    }
        
    /**
     * @return ActiveQuery
     */
    public function getOffice(): ActiveQuery
    {
        return $this->hasOne(\common\models\Office::className(), ['id' => 'office_id']);
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
}
