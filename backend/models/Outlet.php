<?php

namespace backend\models;

use Yii;
use yii\helpers\Html;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

use backend\models\base\Outlet as BaseOutlet;
use backend\models\Counter as Counter;
use backend\models\Enrolment as Enrolment;
use backend\models\ValidityDetail as ValidityDetail;

use common\helper\Helper as Helper;

/**
 * This is the model class for table "tx_outlet".
 */
class Outlet extends BaseOutlet
{
    
    const BILLING_STATUS_NO             = 1; //2 NO
    const BILLING_STATUS_YES            = 2; //3 YES
    const BILLING_STATUS_NA             = 3; //1 NA  
    
    const ASSEMBLY_TYPE_NEW             = 1;
    const ASSEMBLY_TYPE_PARALEL         = 2;
    const ASSEMBLY_TYPE_MOVE            = 3;
    
    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'customer',
            'staff',
            'outletDetails',
            
            'enrolment' //TAMBAHAN
        ];
    }    
    
    
    public static function getArrayAssemblyType()
    {
        return [
            //MASTER
            self::ASSEMBLY_TYPE_NEW             => 'Baru',
            self::ASSEMBLY_TYPE_PARALEL         => 'Paralel',
            self::ASSEMBLY_TYPE_MOVE            => 'Pindah',
        ];
    }

    public static function getOneAssemblyType($_module = null)
    {
        if($_module)
        {
            $arrayModule = self::getArrayAssemblyType();
            $returnValue = 'Unset';
            
            switch ($_module) {
                case ($_module == self::ASSEMBLY_TYPE_NEW):
                    $returnValue = '<span class="label label-primary">'.$arrayModule[$_module].'</span>';
                    break;
                case ($_module == self::ASSEMBLY_TYPE_PARALEL):
                    $returnValue = '<span class="label label-success">'.$arrayModule[$_module].'</span>';
                    break;
                case ($_module == self::ASSEMBLY_TYPE_MOVE):
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
    
    public static function getArrayBillingStatus()
    {
        return [
            //MASTER
            self::BILLING_STATUS_NA             => 'NA',
            self::BILLING_STATUS_NO             => 'Belum',
            self::BILLING_STATUS_YES            => 'Sudah',
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
    
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
            [['staff_id', 'assembly_type', 'date_issued', 'invoice'], 'required'], //TAMBAHAN
            
            [['customer_id', 'staff_id', 'date_issued', 'date_assembly', 'billing_status', 'assembly_type', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['claim'], 'safe'],
            
            [['description'], 'string'],
            
            [['title'], 'string', 'max' => 10],
            [['month_period'], 'string', 'max' => 6],

            [['invoice'], 'string', 'max' => 12],
            [['invoice'], 'unique'],
            [['invoice'], 'validateInvioce'], //ADD
            
            [['verlock', 'is_deleted'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']           
        ];          
    }    
    
    public function validateInvioce($attribute, $params, $validator)
    {
        $invoice = date('y',$this->date_issued).$this->invoice;
        $check = Outlet::find()->where(['invoice'=> $invoice])->one();
        if (!empty($check)) {
            $this->addError($attribute, 'Invoice '.$this->invoice.' sudah ada.');
        }            
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
            'date_assembly'     => Yii::$app->params['Attribute_DateAssembly'],
            'billing_status'    => Yii::$app->params['Attribute_BillingStatus'],
            'assembly_type'     => Yii::$app->params['Attribute_AssemblyType'],
            'month_period'      => Yii::$app->params['Attribute_MonthPeriod'],
            'claim'             => Yii::$app->params['Attribute_Claim'],
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
        return $this->hasOne(Enrolment::className(), ['customer_id' => 'customer_id']);
    }    
    
    public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->isNewRecord) {
            $this->billing_status   = self::BILLING_STATUS_NO;
            $this->title            = Counter::getSerialNumber(Counter::CODE_OF_OUTLET);
            $this->invoice          = date('y',$this->date_issued).$this->invoice;             
        }

        $this->date_issued      = Helper::setDateToNoon($this->date_issued);
        $this->date_assembly    = Helper::setDateToNoon($this->date_assembly);
        
        $this->month_period     = Helper::getMonthPeriod($this->date_issued);
        $this->claim            = Helper::removeNumberSeparator($this->claim);

        return true;
    }     

    public function getUrl(){
        return Yii::$app->getUrlManager()->createUrl(['outlet/view', 'id' => $this->id, 'title' => $this->title]);
    }      
    
    //UNTUK MENGHITUNG TOTAL TAGIHAN
    //TANPA MEMPERHATIKAN KEAKTIFAN DEVICE
    
    /*
     * 
     * KORELASI : FORM OUTLET
     * 
     * TOTAL TAGIHAN ADALAH BIAYA PASANG + IURAN PERDANA
     * 
     * Pasang Paralel dan Pindah, akan MENGHAPUS data validasi 
     * yang belum dibuatkan data tagihannya.
     */
    public function getTotalAssemblyCost(){
        
        $outletDetails = $this->outletDetails;
        $total = 0;
        
        foreach($outletDetails as $outletDetailModel){
            $total = $total + $outletDetailModel->assembly_cost ;
        }
        
        return $total;
    }
    
    public function getTotalMonthlyBill(){
        
        $outletDetails = $this->outletDetails;
        $total = 0;
        
        foreach($outletDetails as $outletDetailModel){
            $total = $total + $outletDetailModel->monthly_bill;
        }
        
        return $total;
    }
    
    public function getBillingTypeFromAssembly(){
        $assemblyType           = $this->assembly_type;
        $billingType            = '';

        $lookupAssemblyTypeNew  = self::ASSEMBLY_TYPE_NEW;
        $lookupBillingTypeNew   = Billing::TYPE_PASANG_BARU;

        $lookupAssemblyTypePar  = self::ASSEMBLY_TYPE_PARALEL;
        $lookupBillingTypePar   = Billing::TYPE_PARALEL;

        $lookupAssemblyTypeMov  = self::ASSEMBLY_TYPE_MOVE;                  
        $lookupBillingTypeMov   = billing::TYPE_PINDAH;
                            
                                
        switch ($assemblyType) {

            case ($assemblyType == $lookupAssemblyTypeNew): 
                $billingType = $lookupBillingTypeNew;
                break;

            case ($assemblyType == $lookupAssemblyTypePar): 
                $billingType = $lookupBillingTypePar;
                break;

            case ($assemblyType == $lookupAssemblyTypeMov): 
                $billingType = $lookupBillingTypeMov;
                break;

            default:

                Yii::$app->getSession()->setFlash('danger', [
                    'message' => Yii::t('app', Html::encode('Salah pembuatan tagihan. Outlet : '.$this->invoice))
                ]);                          

                return $this->redirect(['site/message']);  
        }  
        
        return $billingType;
    }
    
    public function adjustValidityAndBilling(){
        
        ////////////////////////////////////////////////////////
        //DELETE TAGIHAN YANG BELUM DIBAYAR
        $creditBillings = Billing::find()->where([
            'customer_id'=>$this->customer_id,
            'billing_type'=>Billing::TYPE_IURAN,
            'payment_status'=>Billing::PAYMENT_STATUS_CREDIT])
        ->andWhere(['>', 'date_due', $this->date_issued])
        ->all();                              

        foreach ($creditBillings as $creditBillingModel) {
            $creditBillingModel->delete();
        }

        ////////////////////////////////////////////////////////
        //UPDATE DATA VALIDASI YANG BELUM ADA TAGIHANNYA                            
        $validityDetails = ValidityDetail::find()->where([
            'customer_id'=>$this->customer_id,
            'billing_status'=>ValidityDetail::BILLING_STATUS_NO])
        ->andWhere(['>', 'date_due', $this->date_issued])
        ->all();                               

        foreach ($validityDetails as $i => $validityDetailModel) {
            if($i > 0){
                $validityDetailModel->amount = $this->customer->sumMonthlyBill();
                $validityDetailModel->description = $this->getSummary();
                $validityDetailModel->save();
            }
        }        
        
    }    
    
    public function checkBilling(){
        
        $value = '<i class="glyphicon glyphicon-ok"></i>';
        if($this->billing_status==self::BILLING_STATUS_NO){
            $value = Html::a('<i class="glyphicon glyphicon-plus"></i> Tagihan', ['billing/outlet','id'=>$this->id], ['class' => 'btn btn-block btn-danger btn-sm']);
        }
        
        return $value;
    }
    
    public function getSummary(){
        
        $deviceTypeMain     = OutletDetail::DEVICE_TYPE_MAIN;
        $deviceTypeParalel  = OutletDetail::DEVICE_TYPE_PARALEL;
    
        $totalMainDevice    = 0;
        $totalParalelDevice = 0;
        $totalOther         = 0;
        
        $outletDetails      = OutletDetail::find()->where(['outlet_id'=>$this->id])->asArray(); 
        $dataEachLimit      = Yii::$app->params['Data_Each_Limit'];
        
        foreach ($outletDetails->each($dataEachLimit) as $outletDetailModel) {
            if($outletDetailModel['device_type'] == $deviceTypeMain){
                $totalMainDevice = $totalMainDevice + 1;
            }
            elseif($outletDetailModel['device_type'] == $deviceTypeParalel){
                $totalParalelDevice = $totalParalelDevice + 1;
            }
            else{
                $totalOther = $totalOther + 0;
            }
        }
        
        $textMain       = $totalMainDevice.' Induk';
        $textParalel    = ($totalParalelDevice > 0) ? $totalParalelDevice.' Paralel':'';
        $textOther      = ($totalOther > 0) ? $totalOther.' Lainnya':'';
        
        return $textMain.' '.$textParalel.' '.$textOther;
    }
    
    
    public static function countNewOutlet($year,$month){
   
        $assemblyTypeNew    = self::ASSEMBLY_TYPE_NEW;
        $monthPeriod        = (strlen($month) > 1) ?  $month : '0'.$month;
        
        $query  = Outlet::find()
            ->where(['month_period'=>$monthPeriod.$year,'assembly_type'=>$assemblyTypeNew]);    
          
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