<?php

namespace backend\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

use backend\models\base\ValidityDetail as BaseValidityDetail;
use backend\models\Enrolment;
use backend\models\Outlet;
use backend\models\OutletDetail;

use common\helper\Helper as Helper;

/**
 * This is the model class for table "tx_validity_detail".
 */
class ValidityDetail extends BaseValidityDetail
{
    const BILLING_STATUS_NO         = Outlet::BILLING_STATUS_NO; //2 NO
    const BILLING_STATUS_YES        = Outlet::BILLING_STATUS_YES; //3 YES
    const BILLING_STATUS_NA         = Outlet::BILLING_STATUS_NA; //1 NA   
    
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

            [['validity_id','month_period'], 'required'], //TAMBAHAN
            [['validity_id', 'customer_id'], 'checkUniq'], //TAMBAHAN      
            
            [['validity_id', 'customer_id', 'device_status', 'billing_status', 'date_due', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['amount'], 'number'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 10],
            [['month_period'], 'string', 'max' => 6],
            [['verlock', 'is_deleted'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']            
            
        ];          
        
    }  
    
    public static function getArrayBillingStatus()
    {
        return [
            //MASTER
            self::BILLING_STATUS_NA     => 'Tidak Ditagih',
            self::BILLING_STATUS_NO     => 'Belum',
            self::BILLING_STATUS_YES    => 'Sudah',
        ];
    }

    public static function getOneBillingStatus($_module = null)
    {
        if($_module)
        {
            $arrayModule = self::getArrayBillingStatus();
            $returnValue = 'Unset';
            
            switch ($_module) {
                case ($_module == self::BILLING_STATUS_NA):
                    $returnValue = '<span class="label label-default">'.$arrayModule[$_module].'</span>';
                    break;
                case ($_module == self::BILLING_STATUS_NO):
                    $returnValue = '<span class="label label-danger">'.$arrayModule[$_module].'</span>';
                    break;           
                case ($_module == self::BILLING_STATUS_YES):
                    $returnValue = '<span class="label label-success">'.$arrayModule[$_module].'</span>';
                    break;                        
                default:
                    $returnValue = '<span class="label label-default">'.$returnValue.'</span>';
            }                 
            
            return $returnValue;
        }
        else
            return;
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
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'billingStatus',
            'customer',
            'deviceStatus',
            'validity',
            
            'enrolment', //TAMBAHAN
        ];
    }    
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                => 'ID',
            'validity_id'       => Yii::$app->params['Attribute_Validity'],
            'customer_id'       => Yii::$app->params['Attribute_Customer'],
            'title'             => Yii::$app->params['Attribute_Title'],
            'device_status'     => Yii::$app->params['Attribute_Device'],
            'billing_status'    => Yii::$app->params['Attribute_Billing'],
            'date_due'          => Yii::$app->params['Attribute_DateDue'],
            'amount'            => Yii::$app->params['Attribute_Amount'],
            'month_period'      => Yii::$app->params['Attribute_MonthPeriod'],
            'description'       => Yii::$app->params['Attribute_Description'],
            
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
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnrolment()
    {
        return $this->hasOne(\backend\models\Enrolment::className(), ['customer_id' => 'customer_id']);
    }    
    
    
    public function checkUniq($attribute, $params) {
        if ($this->isNewRecord) {
            $model = self::find()->where(['validity_id' => $this->validity_id, 'customer_id' => $this->customer_id])->one();
            if (isset($model) && $model != null){
                $this->addError($attribute, 'Data already added.');
            }            
        }
    }

    public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        
        if ($this->isNewRecord) {
            $this->title        = Counter::getSerialNumber(Counter::CODE_OF_VALIDITY_DETAIL);
        }
        
        $billingCycle           = Enrolment::getBillingCycle($this->customer_id);
        $monthPeriod            = $this->validity->title;
        
        $this->date_due         = Helper::formatBillingCycle($billingCycle, $monthPeriod);        
        
        $this->month_period     = $monthPeriod;
        $this->amount           = Helper::removeNumberSeparator($this->amount);

        return true;
    }    
	
    /**
     *
     */
    public function getUrl()
    {
        return Yii::$app->getUrlManager()->createUrl(['validity-detail/view', 'id' => $this->id, 'title' => $this->title]);
    }   
    
    public static function countByDeviceStatus($status){
        $total = ValidityDetail::find()->select('customer_id,device_status')->where(['device_status'=>$status]);
        return $total->asArray()->distinct()->count();
    }    
    
    public static function countByDateEffective($year,$month,$status){

        $monthPeriod = (strlen($month) > 1) ?  $month : '0'.$month;
        $query  = ValidityDetail::find()->select('id')
            ->where(['month_period'=>$monthPeriod.$year]);
        $query->andWhere(['device_status'=>$status]);

        $queryCount = $query->asArray()->count();
        return (!empty($queryCount)) ? $queryCount: 0 ;

    }    
    
    public static function sumAmount($deviceStatus){
        
        $currDate       = date('d',time());
        $currMonth      = date('m',time());
        $currYear       = date('Y',time());        
        
        $dateFirst      = strtotime($currYear.'-'.'01'.'-'.'01'.' 00:00:01');
        $dateLast       = strtotime($currYear.'-'.$currMonth.'-'.$currDate.' 23:59:59');        
        
        $model = self::find()->where(['device_status'=>$deviceStatus]);
        $model->andWhere(['between', 'date_due',  $dateFirst,  $dateLast]);
        
        return Yii::$app->formatter->asDecimal($model->asArray()->sum('amount'));
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
