<?php

namespace common\models\base;

use Yii;
use yii\db\ActiveQuery;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "tx_office".
 *
 * @property integer $id
 * @property string $unique_id
 * @property string $title
 * @property string $phone_number
 * @property string $fax_number
 * @property string $email
 * @property string $web
 * @property string $address
 * @property string $latitude
 * @property string $longitude
 * @property string $description
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
 * @property \common\models\Article[] $articles
 * @property \common\models\ArticleCategory[] $articleCategories
 * @property \common\models\Asset[] $assets
 * @property \common\models\AssetCategory[] $assetCategories
 * @property \common\models\Author[] $authors
 * @property \common\models\Counter[] $counters
 * @property \common\models\Employment[] $employments
 * @property \common\models\Event[] $events
 * @property \common\models\OfficeLink[] $officeLinks
 * @property \common\models\OfficeMedia[] $officeMedia
 * @property \common\models\Staff[] $staff
 */
class Office extends \yii\db\ActiveRecord
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
            'articles',
            'articleCategories',
            'assets',
            'assetCategories',
            'authors',
            'counters',
            'employments',
            'events',
            'officeLinks',
            'officeMedia',
            'staff'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['description'], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['created_by', 'updated_by', 'is_deleted', 'deleted_by', 'verlock'], 'integer'],
            [['unique_id'], 'string', 'max' => 15],
            [['title', 'phone_number', 'fax_number', 'email', 'web', 'address', 'latitude', 'longitude'], 'string', 'max' => 100],
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
        return 'tx_office';
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
            'unique_id' => Yii::t('app', 'Unique ID'),
            'title' => Yii::t('app', 'Title'),
            'phone_number' => Yii::t('app', 'Phone Number'),
            'fax_number' => Yii::t('app', 'Fax Number'),
            'email' => Yii::t('app', 'Email'),
            'web' => Yii::t('app', 'Web'),
            'address' => Yii::t('app', 'Address'),
            'latitude' => Yii::t('app', 'Latitude'),
            'longitude' => Yii::t('app', 'Longitude'),
            'description' => Yii::t('app', 'Description'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'verlock' => Yii::t('app', 'Verlock'),
            'uuid' => Yii::t('app', 'Uuid'),
        ];
    }
    
    /**
     * @return ActiveQuery
     */
    public function getArticles(): ActiveQuery
    {
        return $this->hasMany(\common\models\Article::className(), ['office_id' => 'id']);
    }
        
    /**
     * @return ActiveQuery
     */
    public function getArticleCategories(): ActiveQuery
    {
        return $this->hasMany(\common\models\ArticleCategory::className(), ['office_id' => 'id']);
    }
        
    /**
     * @return ActiveQuery
     */
    public function getAssets(): ActiveQuery
    {
        return $this->hasMany(\common\models\Asset::className(), ['office_id' => 'id']);
    }
        
    /**
     * @return ActiveQuery
     */
    public function getAssetCategories(): ActiveQuery
    {
        return $this->hasMany(\common\models\AssetCategory::className(), ['office_id' => 'id']);
    }
        
    /**
     * @return ActiveQuery
     */
    public function getAuthors(): ActiveQuery
    {
        return $this->hasMany(\common\models\Author::className(), ['office_id' => 'id']);
    }
        
    /**
     * @return ActiveQuery
     */
    public function getCounters(): ActiveQuery
    {
        return $this->hasMany(\common\models\Counter::className(), ['office_id' => 'id']);
    }
        
    /**
     * @return ActiveQuery
     */
    public function getEmployments(): ActiveQuery
    {
        return $this->hasMany(\common\models\Employment::className(), ['office_id' => 'id']);
    }
        
    /**
     * @return ActiveQuery
     */
    public function getEvents(): ActiveQuery
    {
        return $this->hasMany(\common\models\Event::className(), ['office_id' => 'id']);
    }
        
    /**
     * @return ActiveQuery
     */
    public function getOfficeLinks(): ActiveQuery
    {
        return $this->hasMany(\common\models\OfficeLink::className(), ['office_id' => 'id']);
    }
        
    /**
     * @return ActiveQuery
     */
    public function getOfficeMedia(): ActiveQuery
    {
        return $this->hasMany(\common\models\OfficeMedia::className(), ['office_id' => 'id']);
    }
        
    /**
     * @return ActiveQuery
     */
    public function getStaff(): ActiveQuery
    {
        return $this->hasMany(\common\models\Staff::className(), ['office_id' => 'id']);
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
