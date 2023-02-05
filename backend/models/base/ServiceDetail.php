<?php

namespace backend\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the base model class for table "tx_service_detail".
 *
 * @property integer $id
 * @property integer $service_id
 * @property integer $outlet_detail_id
 * @property integer $service_reason_id
 * @property integer $device_status
 * @property string $month_period
 * @property string $commentary
 * @property string $monthly_bill
 * @property string $claim
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $is_deleted
 * @property integer $deleted_at
 * @property integer $deleted_by
 * @property integer $verlock
 *
 * @property \backend\models\OutletDetail $outletDetail
 * @property \backend\models\ServiceReason $serviceReason
 * @property \backend\models\Service $service
 */
class ServiceDetail extends \yii\db\ActiveRecord
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
            'outletDetail',
            'serviceReason',
            'service'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_id', 'outlet_detail_id', 'service_reason_id', 'device_status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['commentary'], 'string'],
            [['monthly_bill', 'claim'], 'number'],
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
        return 'tx_service_detail';
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
            'service_id' => 'Service ID',
            'outlet_detail_id' => 'Outlet Detail ID',
            'service_reason_id' => 'Service Reason ID',
            'device_status' => 'Device Status',
            'month_period' => 'Month Period',
            'commentary' => 'Commentary',
            'monthly_bill' => 'Monthly Bill',
            'claim' => 'Claim',
            'is_deleted' => 'Is Deleted',
            'verlock' => 'Verlock',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutletDetail()
    {
        return $this->hasOne(\backend\models\OutletDetail::className(), ['id' => 'outlet_detail_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceReason()
    {
        return $this->hasOne(\backend\models\ServiceReason::className(), ['id' => 'service_reason_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(\backend\models\Service::className(), ['id' => 'service_id']);
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
