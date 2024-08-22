<?php

namespace common\models\base;

use Yii;
use yii\db\ActiveQuery;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "tx_asset".
 *
 * @property integer $id
 * @property integer $office_id
 * @property integer $is_visible
 * @property integer $asset_type
 * @property integer $asset_group
 * @property integer $asset_category_id
 * @property string $title
 * @property string $date_issued
 * @property string $asset_name
 * @property string $asset_url
 * @property integer $size
 * @property string $mime_type
 * @property integer $view_counter
 * @property integer $download_counter
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
 * @property \common\models\AssetCategory $assetCategory
 * @property \common\models\Office $office
 */
class Asset extends \yii\db\ActiveRecord
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
            'assetCategory',
            'office'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['office_id', 'is_visible', 'asset_type', 'asset_group', 'asset_category_id', 'size', 'view_counter', 'download_counter', 'created_by', 'updated_by', 'is_deleted', 'deleted_by', 'verlock'], 'integer'],
            [['date_issued', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 200],
            [['asset_name', 'mime_type'], 'string', 'max' => 100],
            [['asset_url'], 'string', 'max' => 500],
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
        return 'tx_asset';
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
            'is_visible' => Yii::t('app', 'Is Visible'),
            'asset_type' => Yii::t('app', 'Asset Type'),
            'asset_group' => Yii::t('app', 'Asset Group'),
            'asset_category_id' => Yii::t('app', 'Asset Category ID'),
            'title' => Yii::t('app', 'Title'),
            'date_issued' => Yii::t('app', 'Date Issued'),
            'asset_name' => Yii::t('app', 'Asset Name'),
            'asset_url' => Yii::t('app', 'Asset Url'),
            'size' => Yii::t('app', 'Size'),
            'mime_type' => Yii::t('app', 'Mime Type'),
            'view_counter' => Yii::t('app', 'View Counter'),
            'download_counter' => Yii::t('app', 'Download Counter'),
            'description' => Yii::t('app', 'Description'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'verlock' => Yii::t('app', 'Verlock'),
            'uuid' => Yii::t('app', 'Uuid'),
        ];
    }
    
    /**
     * @return ActiveQuery
     */
    public function getAssetCategory(): ActiveQuery
    {
        return $this->hasOne(\common\models\AssetCategory::className(), ['id' => 'asset_category_id']);
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
