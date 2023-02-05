<?php

namespace backend\models;

use Yii;
use yii\helpers\Html;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

use backend\models\base\Billing as BaseBilling;
use backend\models\Outlet;
use backend\models\Enrolment;
use backend\models\ValidityDetail;

use common\helper\Helper;
/**
 * This is the model class for table "tx_billing".
 */
class Billing extends BaseBilling
{

    const PAYMENT_STATUS_CREDIT         = 1;    //22
    const PAYMENT_STATUS_INSTALLMENT    = 2;    //23
    const PAYMENT_STATUS_PAID           = 3;    //24
    const PAYMENT_STATUS_CANCEL         = 4;    //1&2

    const TYPE_IURAN                    = 1;    //32
    const TYPE_PASANG_BARU              = 2;    //31 ANALOG
    const TYPE_PINDAH                   = 3;    //34
    const TYPE_PARALEL                  = 4;    //36
    const TYPE_DIGITAL                  = 5;    //36

    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'customer',
            'receivableDetails',
            'enrolment' //TAMBAH
        ];
    }
    
    public static function getArrayPaymentStatus()
    {
        return [
            //MASTER
            self::PAYMENT_STATUS_CREDIT         => 'Hutang',
            self::PAYMENT_STATUS_INSTALLMENT    => 'Cicilan',
            self::PAYMENT_STATUS_PAID           => 'Lunas',
            self::PAYMENT_STATUS_CANCEL         => 'Batal',
        ];
    }

    public static function getOnePaymentStatus($_module = null)
    {
        if($_module)
        {
            $arrayModule = self::getArrayPaymentStatus();
            $returnValue = 'Unset';
            
            switch ($_module) {
                case ($_module == self::PAYMENT_STATUS_CREDIT):
                    $returnValue = '<span class="label label-danger">'.$arrayModule[$_module].'</span>';
                    break;
                case ($_module == self::PAYMENT_STATUS_INSTALLMENT):
                    $returnValue = '<span class="label label-warning">'.$arrayModule[$_module].'</span>';
                    break;
                case ($_module == self::PAYMENT_STATUS_PAID):
                    $returnValue = '<span class="label label-success">'.$arrayModule[$_module].'</span>';
                    break;
                case ($_module == self::PAYMENT_STATUS_CANCEL):
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

    public static function getArrayBillingType()
    {
        return [
            //MASTER
            self::TYPE_IURAN        => 'Iuran',
            self::TYPE_PASANG_BARU  => 'Pasang',
            self::TYPE_PINDAH       => 'Pindah',
            self::TYPE_PARALEL      => 'Paralel',
            self::TYPE_DIGITAL      => 'Pasang Digital',
        ];
    }

    public static function getOneBillingType($_module = null)
    {
        if($_module)
        {
            $arrayModule = self::getArrayBillingType();
            $returnValue = 'Unset';
            
            switch ($_module) {
                case ($_module == self::TYPE_IURAN):
                    $returnValue = '<span class="label label-primary">'.$arrayModule[$_module].'</span>';
                    break;
                case ($_module == self::TYPE_PASANG_BARU):
                    $returnValue = '<span class="label label-success">'.$arrayModule[$_module].'</span>';
                    break;
                case ($_module == self::TYPE_PINDAH):
                    $returnValue = '<span class="label label-warning">'.$arrayModule[$_module].'</span>';
                    break;
                case ($_module == self::TYPE_PARALEL):
                    $returnValue = '<span class="label label-danger">'.$arrayModule[$_module].'</span>';
                    break;   
                case ($_module == self::TYPE_DIGITAL):
                    $returnValue = '<span class="label label-info">'.$arrayModule[$_module].'</span>';
                    break;      
                default:
                    $returnValue = '<span class="label label-default">'.$returnValue.'</span>';
            }                 
            
            return $returnValue;
        }
        else
            return;
    }

    public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->isNewRecord) {
            $this->area_id  = $this->customer->area_id;
        }        
        
        $this->date_issued  = Helper::setDateToNoon($this->date_issued);
        $this->date_due     = Helper::setDateToNoon($this->date_due);

        return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnrolment()
    {
        return $this->hasOne(Enrolment::className(), ['customer_id' => 'customer_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {

        return [
            [['customer_id', 'area_id', 'date_issued', 'date_due', 'billing_type', 'payment_status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['amount'], 'number'],
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
            'area_id'           => Yii::$app->params['Attribute_Area'],
            'title'             => Yii::$app->params['Attribute_Number'],
            'invoice'           => Yii::$app->params['Attribute_Invoice'],
            'amount'            => Yii::$app->params['Attribute_Amount'],
            'date_issued'       => Yii::$app->params['Attribute_DateIssued'],
            'date_due'          => Yii::$app->params['Attribute_DateDue'],
            'month_period'      => Yii::$app->params['Attribute_MonthPeriod'],
            'billing_type'      => 'Tagihan',//Yii::$app->params['Attribute_Type'],
            'payment_status'    => Yii::$app->params['Attribute_Status'],
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

    public function beforeDelete() {
        if (!parent::beforeDelete()) {
            return false;
        }

        if($this->billing_type == self::TYPE_PASANG_BARU ||
                $this->billing_type == self::TYPE_PARALEL ||
                $this->billing_type == self::TYPE_PINDAH){

            $outlet = Outlet::find()->where(['title'=> $this->invoice])->one();
            $outlet->billing_status = Outlet::BILLING_STATUS_NO;

            $outlet->save();

        }
        elseif($this->billing_type == self::TYPE_IURAN){
            $validityDetail = ValidityDetail::find()->where(['title'=> $this->invoice])->one();
            if(!empty($validityDetail)){
                $validityDetail->billing_status = ValidityDetail::BILLING_STATUS_NO;
                $validityDetail->save();
            }
        }

        return true;
    }

    /**
     *
     */
    public function getUrl()
    {
        return Yii::$app->getUrlManager()->createUrl(['billing/view', 'id' => $this->id, 'title' => $this->title]);
    }

    public function checkReceivable(){
        $receivables = $this->receivableDetails;

        $delete = Html::a('<i class="fa fa-trash"></i>', ['billing/delete', 'id' => $this->id], [
            'class' => '',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]);

        $status = '';
        if(empty($receivables) && $this->payment_status <> self::PAYMENT_STATUS_CREDIT){
            $status = '<span class="label label-danger">Invalid</span> '.$delete;
        }

        return $status;
    }

    /**
     *
     */
    public function getInvoiceUrl()
    {
        $invoiceUrl = '#';

        if($this->billing_type == self::TYPE_PASANG_BARU || //BILLING TYPE DEVICE ASSEMBLY NEW
                $this->billing_type == self::TYPE_PARALEL || //BILLING TYPE DEVICE ASSEMBLY PARALEL
                $this->billing_type == self::TYPE_PINDAH){ //BILLING TYPE DEVICE ASSEMBLY MOVE
            $model = Outlet::find()->where(['title'=> $this->invoice])->one();
            $invoiceUrl = Yii::$app->getUrlManager()->createUrl(['outlet/view', 'id' => $model->id, 'title' => $model->title]);
        }
        elseif($this->billing_type == self::TYPE_IURAN){//BILLING TYPE MONTHLY INSTALLMENT
            $model = ValidityDetail::find()->where(['title'=> $this->invoice])->one();
            if(!empty($model)){
                $invoiceUrl = Yii::$app->getUrlManager()->createUrl(['validity-detail/view', 'id' => $model->id, 'title' => $model->validity->title]);
            }
        }
        return $invoiceUrl;
    }

    public static function countByStatusType($year,$month,$attribute,$status){

        $monthPeriod = (strlen($month) > 1) ?  $month : '0'.$month;
        $query  = Billing::find()
            ->where(['month_period'=>$monthPeriod.$year]);
        $query->andWhere([$attribute=>$status]);

        $queryCount = $query->asArray()->count();
        return (!empty($queryCount)) ? $queryCount: 0 ;

    }
    
    public static function countByPaymentStatus($status){
        $total = Billing::find()->select('payment_status')
                ->where(['payment_status'=>$status])
                ->orderBy(['created_at' => SORT_ASC]);
        return $total->asArray()->count();
    }    

    public static function countPaymentStatusYearly($year,$month,$status){
        $monthPeriod = (strlen($month) > 1) ?  $month : '0'.$month;
        $query  = self::find()->select('id')
            ->where(['month_period'=>$monthPeriod.$year]);
        $query->andWhere(['payment_status'=>$status]);

        $queryCount = $query->asArray()->count();
        return (!empty($queryCount)) ? $queryCount: 0 ;
    }        
    
    public static function countPaymentStatusYearlyByArea($year,$month,$status,$area){
        $monthPeriod = (strlen($month) > 1) ?  $month : '0'.$month;
        $query  = self::find()->select('id')
                    ->where(['month_period'=>$monthPeriod.$year])
                    ->andWhere(['area_id'=>$area]);
        $query->andWhere(['payment_status'=>$status]);
        
        $queryCount = $query->asArray()->count();
        return (!empty($queryCount)) ? $queryCount: 0 ;
    }        
    
    public function getBillingTypeLabel(){
        return self::getOneBillingType($this->billing_type);
    }
    
    public static function sumAmount($deviceStatus){
        $currDate       = date('d',time());
        $currMonth      = date('m',time());
        $currYear       = date('Y',time());        
        
        $dateFirst      = strtotime($currYear.'-'.'01'.'-'.'01'.' 00:00:01');
        $dateLast       = strtotime($currYear.'-'.$currMonth.'-'.$currDate.' 23:59:59');
        
        $model = self::find()->where(['payment_status'=>$deviceStatus]);
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
