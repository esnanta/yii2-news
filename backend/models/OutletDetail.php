<?php

namespace backend\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

use backend\models\base\OutletDetail as BaseOutletDetail;
use backend\models\Enrolment;

use common\helper\Helper as Helper;

/**
 * This is the model class for table "tx_outlet_detail".
 */
class OutletDetail extends BaseOutletDetail
{
    
    const DEVICE_STATUS_ACTIVE      = 1; //27 AKTIV
    const DEVICE_STATUS_FREE        = 2; //28 FREE
    const DEVICE_STATUS_IDLE        = 3; //29 DC SEMENTARA
    const DEVICE_STATUS_DISCONNECT  = 4; //30 DISCONNECT
    const DEVICE_STATUS_NA          = 5; //30 NA / PASCA DI DELETE SERVICE NYA
    
    const DEVICE_TYPE_MAIN          = 1; //25 INDUK
    const DEVICE_TYPE_PARALEL       = 2; //26 PARALEL
    
    const ENROLMENT_TYPE_ANALOG     = Enrolment::ENROLMENT_TYPE_ANALOG;
    const ENROLMENT_TYPE_DIGITAL    = Enrolment::ENROLMENT_TYPE_DIGITAL;
    
    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'customer',
            'outlet',
            'serviceDetails',
            'enrolment' //TAMBAH
        ];
    }    
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return
	    [
                
            [['device_type', 'assembly_cost', 'monthly_bill'], 'required'],
                
            [['outlet_id', 'customer_id', 'enrolment_type', 'device_type', 'device_status', 
                'created_at', 'updated_at', 'created_by', 'updated_by', 
                'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
                
            [['assembly_cost', 'monthly_bill'], 'safe'],
            [['description'], 'string'],
            [['verlock', 'is_deleted'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }
    
    public static function getArrayDeviceType()
    {
        return [
            //MASTER
            self::DEVICE_TYPE_MAIN          => 'Induk',
            self::DEVICE_TYPE_PARALEL       => 'Paralel',
        ];
    }

    public static function getOneDeviceType($_module = null)
    {
        if($_module)
        {
            $arrayModule = self::getArrayDeviceType();
            $returnValue = 'Unset';
            
            switch ($_module) {
                case ($_module == self::DEVICE_TYPE_MAIN):
                    $returnValue = '<span class="label label-primary">'.$arrayModule[$_module].'</span>';
                    break;
                case ($_module == self::DEVICE_TYPE_PARALEL):
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
    
    public static function getArrayEnrolmentType()
    {
        return [
            //MASTER
            self::ENROLMENT_TYPE_ANALOG   => 'Analog',
            self::ENROLMENT_TYPE_DIGITAL  => 'Digital',
        ];
    }

    public static function getOneEnrolmentType($_module = null)
    {
        if($_module)
        {
            $arrayModule = self::getArrayEnrolmentType();
            $returnValue = 'Unset';

            switch ($_module) {
                case ($_module == self::ENROLMENT_TYPE_ANALOG):
                    $returnValue = '<span class="label label-danger">'.$arrayModule[$_module].'</span>';
                    break;
                case ($_module == self::ENROLMENT_TYPE_DIGITAL):
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
            'outlet_id'         => Yii::$app->params['Attribute_Outlet'],
            'customer_id'       => Yii::$app->params['Attribute_Customer'],
            'assembly_cost'     => Yii::$app->params['Attribute_AssemblyCost'],
            'monthly_bill'      => Yii::$app->params['Attribute_MonthlyFee'],
            'enrolment_type'    => 'Langganan',
            'device_type'       => Yii::$app->params['Attribute_Type'],
            'device_status'     => Yii::$app->params['Attribute_Status'],
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
    
    public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        
        if ($this->isNewRecord) {
           $this->customer_id      = $this->outlet->customer_id; 
           $this->device_status    = self::DEVICE_STATUS_ACTIVE; 
        }
        
        $this->assembly_cost    = Helper::removeNumberSeparator($this->assembly_cost);
        $this->monthly_bill     = Helper::removeNumberSeparator($this->monthly_bill);

        return true;
    }          
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnrolment()
    {
        return $this->hasOne(\backend\models\Enrolment::className(), ['customer_id' => 'customer_id']);
    }         
    
    public function getUrl()
    {
        return Yii::$app->getUrlManager()->createUrl(['outlet/view', 'id' => $this->outlet->id, 'title' => $this->outlet->title]);
    }  
    public function getTitle()
    {
        return $this->outlet->title;
    }     
    
    public static function sumMonthlyBillByOutlet($id,$status) {
        $query = OutletDetail::find()->where(['outlet_id'=>$id]);
        $query->andWhere(['device_status'=> $status]);
        return $query->sum('monthly_bill');
    }      
    
    public static function getDeviceByCustomer($id) {
        
        $deviceStatusActive = self::DEVICE_STATUS_ACTIVE;
        $deviceStatusFree   = self::DEVICE_STATUS_FREE;
        $deviceStatusIdle   = self::DEVICE_STATUS_IDLE;
        $deviceStatusDc     = self::DEVICE_STATUS_DISCONNECT;
        
        $outletDetails = OutletDetail::find()->where([
            'customer_id'   => $id,
        ])->all();        
        
        $deviceStatus = $deviceStatusDc;
        
        //BREAK IF FOUND 1 ACTIVE OUTLET DEVICE
        foreach ($outletDetails as $outletDetailModel) {
            if($outletDetailModel->device_status==$deviceStatusIdle){
                $deviceStatus = $outletDetailModel->device_status;
            }
            elseif($outletDetailModel->device_status==$deviceStatusFree){
                $deviceStatus = $outletDetailModel->device_status;
            }            
            elseif($outletDetailModel->device_status==$deviceStatusActive){
                $deviceStatus = $outletDetailModel->device_status;
                break;
            }            
        }
        
        return $deviceStatus;
    }    
    
    public static function countByDeviceStatus($status){
        $total = OutletDetail::find()->select('customer_id,device_status')
                ->where(['device_status'=>$status])
                ->orderBy(['created_at' => SORT_ASC]);
        return $total->asArray()->distinct()->count();
    }
    
    public static function getDistinctDevicesByActive(){
        $total  = OutletDetail::find()->select('customer_id, device_status')
                ->where(['device_status' => self::DEVICE_STATUS_ACTIVE])
                ->orderBy(['created_at' => SORT_ASC]);
        return $total->asArray()->distinct();
    }   
    
    public static function getDistinctDevicesWithoutDC(){
        $total  = OutletDetail::find()->select('customer_id, device_status')
                ->where(['<>', 'device_status', self::DEVICE_STATUS_DISCONNECT])
                ->orderBy(['created_at' => SORT_ASC]);
        return $total->asArray()->distinct();
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
