<?php

namespace backend\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "tx_comment".
 *
 * @property integer $id
 * @property integer $blog_id
 * @property string $title
 * @property string $author
 * @property string $email
 * @property string $url
 * @property string $content
 * @property integer $publish_status
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $create_by
 * @property integer $update_by
 * @property string $verlock
 *
 * @property \backend\models\Blog $blog
 * @property \backend\models\Lookup $publishStatus
 */
class Comment extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'blog',
            'publishStatus'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['blog_id', 'title', 'content'], 'required'],
            [['blog_id', 'publish_status', 'create_time', 'update_time', 'create_by', 'update_by', 'verlock'], 'integer'],
            [['content'], 'string'],
            [['title', 'author', 'email', 'url'], 'string', 'max' => 100],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tx_comment';
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
            'blog_id' => 'Blog ID',
            'title' => 'Title',
            'author' => 'Author',
            'email' => 'Email',
            'url' => 'Url',
            'content' => 'Content',
            'publish_status' => 'Publish Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_by' => 'Create By',
            'update_by' => 'Update By',
            'verlock' => 'Verlock',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlog()
    {
        return $this->hasOne(\backend\models\Blog::className(), ['id' => 'blog_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPublishStatus()
    {
        return $this->hasOne(\backend\models\Lookup::className(), ['id' => 'publish_status']);
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
                'createdAtAttribute' => 'create_time',
                'updatedAtAttribute' => 'update_time',
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'create_by',
                'updatedByAttribute' => 'update_by',
            ],
        ];
    }
}
