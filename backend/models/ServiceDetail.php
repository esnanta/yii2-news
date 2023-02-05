<?php

namespace backend\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

use \backend\models\base\ServiceDetail as BaseServiceDetail;
use \backend\models\OutletDetail as OutletDetail;

use common\helper\Helper as Helper;
/**
 * This is the model class for table "tx_service_detail".
 */
class ServiceDetail extends BaseServiceDetail
{

    const DEVICE_STATUS_ACTIVE      = OutletDetail::DEVICE_STATUS_ACTIVE; //27 AKTIV
    const DEVICE_STATUS_FREE        = OutletDetail::DEVICE_STATUS_FREE; //28 FREE
    const DEVICE_STATUS_IDLE        = OutletDetail::DEVICE_STATUS_IDLE; //29 DC SEMENTARA
    const DEVICE_STATUS_DISCONNECT  = OutletDetail::DEVICE_STATUS_DISCONNECT; //30 DISCONNECT
    const DEVICE_STATUS_NA          = OutletDetail::DEVICE_STATUS_NA; //30 DISCONNECT
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['service_reason_id', 'device_status'], 'required'], //TAMBAHAN

            [['monthly_bill', 'claim'], 'safe'],
            [['service_id', 'outlet_detail_id', 'service_reason_id', 'device_status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['month_period'], 'string', 'max' => 6],
            [['commentary'], 'string'],
            [['verlock', 'is_deleted'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }

    public static function getArrayDeviceStatus()
    {
        return [
            //MASTER
            self::DEVICE_STATUS_ACTIVE      => 'Aktif',
            self::DEVICE_STATUS_FREE        => 'Gratis',
            self::DEVICE_STATUS_IDLE        => 'DC Sementara',
            self::DEVICE_STATUS_DISCONNECT  => 'DC Permanen',
            self::DEVICE_STATUS_NA          => 'NA',
        ];
    }

    public static function getOneDeviceStatus($_module = null)
    {
        if($_module)
        {
            $arrayModule = self::getArrayDeviceStatus();
            $returnValue = 'Unset';
            
            switch ($_module) {
                case ($_module == self::DEVICE_STATUS_ACTIVE):
                    $returnValue = '<span class="label label-primary">'.$arrayModule[$_module].'</span>';
                    break;
                case ($_module == self::DEVICE_STATUS_FREE):
                    $returnValue = '<span class="label label-success">'.$arrayModule[$_module].'</span>';
                    break;           
                case ($_module == self::DEVICE_STATUS_IDLE):
                    $returnValue = '<span class="label label-warning">'.$arrayModule[$_module].'</span>';
                    break;       
                case ($_module == self::DEVICE_STATUS_DISCONNECT):
                    $returnValue = '<span class="label label-danger">'.$arrayModule[$_module].'</span>';
                    break;  
                case ($_module == self::DEVICE_STATUS_NA):
                        $returnValue = '<span class="label label-default">'.$arrayModule[$_module].'</span>';
                        break;                 
                default:
                    $returnValue = '<span class="label label-default">'.$returnValue.'</span>';
            }                 
            
            return $returnValue;
        }
        else
            return;
    }      
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                => 'ID',
            'service_id'        => Yii::$app->params['Attribute_Service'],
            'outlet_detail_id'  => Yii::$app->params['Attribute_Outlet'],
            'service_reason_id' => Yii::$app->params['Attribute_Reason'],
            'device_status'     => Yii::$app->params['Attribute_Status'],
            'month_period'      => Yii::$app->params['Attribute_MonthPeriod'],
            'monthly_bill'      => Yii::$app->params['Attribute_MonthlyFee'],
            'claim'             => Yii::$app->params['Attribute_Claim'],
            'commentary'        => Yii::$app->params['Attribute_Description'],
            
            'created_at'        => Yii::$app->params['Attribute_CreatedAt'],
            'updated_at'        => Yii::$app->params['Attribute_UpdatedAt'],
            'created_by'        => Yii::$app->params['Attribute_CreatedBy'],
            'updated_by'        => Yii::$app->params['Attribute_UpdatedBy'],
            
            'is_deleted'        => 'Deleted',
            'deleted_at'        => Yii::$app->params['Attribute_DeletedAt'],
            'deleted_by'        => Yii::$app->params['Attribute_DeletedBy'],
                       
            'verlock'           => 'Verlock',
        ];
    }

    public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if(!empty($this->service_reason_id) && !empty($this->device_status)){
            $outletDetail = OutletDetail::find()->where(['id'=>$this->outlet_detail_id])->one();
            $outletDetail->device_status = $this->device_status;
            $outletDetail->save();
        }

        $this->month_period = Helper::getMonthPeriod($this->service->date_effective);
        $this->monthly_bill = Helper::removeNumberSeparator($this->monthly_bill);

        return true;
    }

    public function beforeDelete() {
        if (parent::beforeDelete()) {
            $outletDetail = OutletDetail::find()->where(['id'=>$this->outlet_detail_id])->one();
            $outletDetail->device_status = OutletDetail::DEVICE_STATUS_NA;
            $outletDetail->save();
            return true;
        } else {
            return false;
        }
    }

    public static function countByDateEffective($year,$month,$status){

        $monthPeriod = (strlen($month) > 1) ?  $month : '0'.$month;
        $query  = ServiceDetail::find()
            ->where(['month_period'=>$monthPeriod.$year]);
        $query->andWhere(['device_status'=>$status]);

        $queryCount = $query->asArray()->count();
        return (!empty($queryCount)) ? $queryCount: 0 ;

    }
    
    public function behaviors() {
        return [             
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }        
}
