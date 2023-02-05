<?php

namespace backend\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "tx_blog".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $author_id
 * @property string $title
 * @property string $cover
 * @property string $url
 * @property string $content
 * @property string $description
 * @property string $tags
 * @property string $month_period
 * @property integer $publish_status
 * @property integer $pinned_status
 * @property integer $view_counter
 * @property double $rating
 * @property integer $date_issued
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $is_deleted
 * @property integer $deleted_by
 * @property integer $deleted_at
 * @property integer $verlock
 *
 * @property \backend\models\Author $author
 * @property \backend\models\Category $category
 */
class Blog extends \yii\db\ActiveRecord
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
    public function relationNames()
    {
        return [
            'author',
            'category'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'title', 'content', 'publish_status'], 'required'],
            [['category_id', 'author_id', 'publish_status', 'pinned_status', 'view_counter', 'date_issued', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_by', 'deleted_at', 'verlock'], 'integer'],
            [['content', 'description', 'tags'], 'string'],
            [['rating'], 'number'],
            [['title'], 'string', 'max' => 150],
            [['cover', 'url'], 'string', 'max' => 300],
            [['month_period'], 'string', 'max' => 6],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tx_blog';
    }

    /**
     *
     * @return string
     * overwrite function optimisticLock
     * return string name of field are used to stored optimistic lock
     *
     */
    public function optimisticLock() {
        return 'verlock';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'author_id' => 'Author ID',
            'title' => 'Title',
            'cover' => 'Cover',
            'url' => 'Url',
            'content' => 'Content',
            'description' => 'Description',
            'tags' => 'Tags',
            'month_period' => 'Month Period',
            'publish_status' => 'Publish Status',
            'pinned_status' => 'Pinned Status',
            'view_counter' => 'View Counter',
            'rating' => 'Rating',
            'date_issued' => 'Date Issued',
            'is_deleted' => 'Is Deleted',
            'verlock' => 'Verlock',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(\backend\models\Author::className(), ['id' => 'author_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(\backend\models\Category::className(), ['id' => 'category_id']);
    }
    
    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }
}
