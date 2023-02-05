<?php

namespace backend\models;

use Yii;
use backend\models\base\Service as BaseService;
use backend\models\OutletDetail;
use backend\models\Validity;
use backend\models\ValidityDetail;
use backend\models\Billing;


use common\helper\Helper;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "tx_service".
 */
class Service extends BaseService
{

    const SERVICE_TYPE_GENERAL              = 1;
    const SERVICE_TYPE_CHANGE_TO_DIGITAL    = 2;
    const SERVICE_TYPE_EXTEND_DIGITAL       = 3;

    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'customer',
            'staff',
            'serviceDetails',

            'enrolment' //TAMBAHAN
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // TAMBAHAN
            [['staff_id', 'date_issued','date_effective','staff_id'], 'required'],
            [['claim', 'surcharge', 'total'], 'safe'],

            [['customer_id', 'staff_id', 'date_issued', 'date_effective',
                'service_type', 'date_start', 'date_end', 'billing_cycle',
                'created_at', 'updated_at', 'created_by', 'updated_by',
                'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['description'], 'string'],
            [['title', 'invoice'], 'string', 'max' => 10],
            [['month_period'], 'string', 'max' => 6],
            [['verlock', 'is_deleted'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ];

    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                => 'ID',
            'customer_id'       => Yii::$app->params['Attribute_Customer'],
            'staff_id'          => Yii::$app->params['Attribute_Staff'],
            'title'             => Yii::$app->params['Attribute_Number'],
            'invoice'           => Yii::$app->params['Attribute_Invoice'],
            'date_issued'       => Yii::$app->params['Attribute_DateIssued'],
            'date_effective'    => Yii::$app->params['Attribute_DateEffective'],
            'service_type'      => Yii::$app->params['Attribute_Type'],
            'billing_cycle'     => Yii::$app->params['Attribute_BillingCycle'],
            'date_start'        => Yii::$app->params['Attribute_DateStart'],
            'date_end'          => Yii::$app->params['Attribute_DateEnd'],
            'month_period'      => Yii::$app->params['Attribute_MonthPeriod'],
            'description'       => Yii::$app->params['Attribute_Description'],

            'claim'             => Yii::$app->params['Attribute_Claim'],
            'surcharge'         => Yii::$app->params['Attribute_Surcharge'],
            'total'             => Yii::$app->params['Attribute_Total'],

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

        if ($this->isNewRecord) {
            $this->title            = Counter::getSerialNumber(Counter::CODE_OF_SERVICE);
        }

        $this->date_effective       = Helper::setDateToNoon($this->date_effective);
        $this->date_issued          = Helper::setDateToNoon($this->date_issued);
        $this->date_start           = Helper::setDateToNoon($this->date_start);
        $this->date_end             = Helper::setDateToNoon($this->date_end);
        $this->month_period         = Helper::getMonthPeriod($this->date_issued);

        $this->claim                = Helper::removeNumberSeparator($this->claim);
        $this->surcharge            = Helper::removeNumberSeparator($this->surcharge);
        $this->total                = Helper::removeNumberSeparator($this->total);

        return true;
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnrolment()
    {
        return $this->hasOne(\backend\models\Enrolment::className(), ['customer_id' => 'customer_id']);
    }

    public function addDigitalValidityBilling($_type){

        $dateDue = $this->date_start;

        if($_type == Service::SERVICE_TYPE_EXTEND_DIGITAL){

            $monthPeriod    = Helper::getMonthPeriod($dateDue);
            $validity       = Validity::find()->where(['title'=>$monthPeriod])->one();

            if(empty($validity)){
                $validity           = new Validity;
                $validity->title    = $monthPeriod;
                $validity->counter  = 0;
                $validity->save();
            }

            $deviceStatus   = OutletDetail::getDeviceByCustomer($this->customer_id);

            //TAGIHAN UNTUK PERPANJANG ADALAH IURAN BULANAN SAJA
            //CLAIM = TOTAL IURAN BULANAN
            //SUMBER DATA ADALAH DETAIL SERVICE
            $amount                         = $this->claim;

            $validityDetail                 = new ValidityDetail;
            $validityDetail->validity_id    = $validity->id;
            $validityDetail->customer_id    = $this->customer_id;
            $validityDetail->device_status  = $deviceStatus;
            $validityDetail->billing_status = ValidityDetail::BILLING_STATUS_YES;
            $validityDetail->date_due       = $dateDue;
            $validityDetail->amount         = $amount;
            $validityDetail->month_period   = Helper::getMonthPeriod($dateDue);
            $validityDetail->description    = strip_tags($this->getOneServiceType($this->service_type)).' '.$this->title;
            $validityDetail->save();

            if($deviceStatus == ValidityDetail::DEVICE_STATUS_ACTIVE){
                $billing                    = new Billing;
                $billing->customer_id       = $this->customer_id;
                $billing->area_id           = $this->customer->area_id;
                $billing->title             = Counter::getSerialNumber(Counter::CODE_OF_BILLING);
                $billing->invoice           = $validityDetail->title;
                $billing->amount            = $amount;
                $billing->date_issued       = $this->date_issued;
                $billing->date_due          = $dateDue;
                $billing->month_period      = Helper::getMonthPeriod($dateDue);
                $billing->payment_status    = Billing::PAYMENT_STATUS_CREDIT;
                $billing->billing_type      = Billing::TYPE_IURAN;
                $billing->description       = $validityDetail->description;
                $billing->save();
            }

        }

        else if($_type == Service::SERVICE_TYPE_CHANGE_TO_DIGITAL){

            //TAGIHAN UNTUK PINDAH DIGITAL ADALAH SELURUH BIAYA YANG DITIMBULKAN
            //CLAIM = TOTAL
            //SUMBER DATA ADALAH SERVICE
            $amount                     = $this->total;

            $billing                    = new Billing;
            $billing->customer_id       = $this->customer_id;
            $billing->area_id           = $this->customer->area_id;
            $billing->title             = Counter::getSerialNumber(Counter::CODE_OF_BILLING);
            $billing->invoice           = $this->title;
            $billing->amount            = $amount;
            $billing->date_issued       = $this->date_issued;
            $billing->date_due          = $dateDue;
            $billing->month_period      = Helper::getMonthPeriod($dateDue);
            $billing->payment_status    = Billing::PAYMENT_STATUS_CREDIT;
            $billing->billing_type      = Billing::TYPE_DIGITAL;
            $billing->description       = 'Pasang Digital | Serv '.$this->title.' | '.$billing->month_period;
            $billing->save();
        }


    }

    public function updateValidityAndBilling(){

        $billingTypeMonthly     = Billing::TYPE_IURAN;
        $paymentStatusCredit    = Billing::PAYMENT_STATUS_CREDIT;
        $deviceStatus           = OutletDetail::getDeviceByCustomer($this->customer_id);

        $validityDetailDeviceStatusActive   = ValidityDetail::DEVICE_STATUS_ACTIVE;
        $validityDetailBillingStatusYes     = ValidityDetail::BILLING_STATUS_YES;

        $billings = Billing::find()->where([
            'customer_id'       => $this->customer_id,
            'payment_status'    => $paymentStatusCredit,
            'billing_type'      => $billingTypeMonthly])
        ->andWhere(['>', 'date_due', $this->date_effective])
        ->all();

        foreach ($billings as $i=>$billingModel) {
            $billingModel->delete();
        }

        $validityDetails = ValidityDetail::find()->where([
            'customer_id'=>$this->customer_id,
        ])
        ->andWhere(['<>','billing_status',$validityDetailBillingStatusYes])
        ->andWhere(['>', 'date_due', $this->date_effective])
        ->all();

        foreach ($validityDetails as $i=>$validityDetailModel) {

            $description = 'Updated by Service '.$this->title;
            $amount      = $this->customer->sumMonthlyBill();

            //DEVICE STATUS <> ACTIVE
            if($deviceStatus!=$validityDetailDeviceStatusActive){
                $validityDetailModel->device_status = $deviceStatus;
                $validityDetailModel->description = $description;
                $validityDetailModel->save();
            }

            //DEVICE STATUS == ACTIVE
            elseif($deviceStatus==$validityDetailDeviceStatusActive){
                $validityDetailModel->device_status = $deviceStatus;
                $validityDetailModel->amount = $amount;
                $validityDetailModel->description = $description;
                $validityDetailModel->save();
            }
        }
    }

    public function getUrl()
    {
        return Yii::$app->getUrlManager()->createUrl(['service/view', 'id' => $this->id, 'title' => $this->title]);
    }

    public function getSummary(){
        $serviceDetails = $this->serviceDetails;
        $value = '';
        foreach ($serviceDetails as $serviceDetailModel) {
            $value = $value.$serviceDetailModel->serviceType->title.' -> '.$serviceDetailModel->getOneDeviceStatus($serviceDetailModel->device_status).'<br>';
        }
        return $value;
    }

    public static function getArrayServiceType()
    {
        return [
            //MASTER
            self::SERVICE_TYPE_GENERAL              => 'Layanan Analog',
            self::SERVICE_TYPE_CHANGE_TO_DIGITAL    => 'Ubah Ke Digital',
            self::SERVICE_TYPE_EXTEND_DIGITAL       => 'Layanan Digital',
        ];
    }

    public static function getOneServiceType($_module = null)
    {
        if($_module)
        {
            $arrayModule = self::getArrayServiceType();
            $returnValue = 'Unset';

            switch ($_module) {
                case ($_module == self::SERVICE_TYPE_GENERAL):
                    $returnValue = '<span class="label label-warning">'.$arrayModule[$_module].'</span>';
                    break;
                case ($_module == self::SERVICE_TYPE_CHANGE_TO_DIGITAL):
                    $returnValue = '<span class="label label-success">'.$arrayModule[$_module].'</span>';
                    break;
                case ($_module == self::SERVICE_TYPE_EXTEND_DIGITAL):
                    $returnValue = '<span class="label label-primary">'.$arrayModule[$_module].'</span>';
                    break;
                default:
                    $returnValue = '<span class="label label-danger">'.$returnValue.'</span>';
            }

            return $returnValue;
        }
        else
            return;
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
