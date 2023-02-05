<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper; 
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

use backend\models\base\Customer as BaseCustomer;
use backend\models\Counter as Counter;
use backend\models\OutletDetail as OutletDetail;

use common\helper\Helper;

/**
 * This is the model class for table "tx_customer".
 */
class Customer extends BaseCustomer
{
    const GENDER_MALE           = 1;
    const GENDER_FEMALE         = 2;    
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['area_id', 'village_id', 'gender_status', 'date_issued', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['address', 'description'], 'string'],
            [['customer_number'], 'string', 'max' => 10],
            [['identity_number', 'title', 'phone_number'], 'string', 'max' => 50],
            [['customer_number'], 'unique'],                
            [['verlock', 'is_deleted'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ];          
    }

    public static function getArrayModule()
    {
        return [
            //MASTER
            self::GENDER_MALE       => 'Laki-laki',
            self::GENDER_FEMALE     => 'Perempuan', 
        ];
    }    
    
    public static function getOneModule($_module = null)
    {
        if($_module)
        {
            $arrayModule = self::getArrayModule();
            $returnValue = 'Unset';
            
            switch ($_module) {
                case ($_module == self::GENDER_MALE):
                    $returnValue = '<span class="label label-default">'.$arrayModule[$_module].'</span>';
                    break;
                case ($_module == self::GENDER_FEMALE):
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
            'area_id'           => Yii::$app->params['Attribute_Area'],
            'village_id'        => Yii::$app->params['Attribute_Village'],
            'customer_number'   => Yii::$app->params['Attribute_CustomerNumber'],
            'identity_number'   => Yii::$app->params['Attribute_IdentityNumber'],
            'title'             => Yii::$app->params['Attribute_Title'],
            'gender_status'     => Yii::$app->params['Attribute_GenderStatus'],
            'address'           => Yii::$app->params['Attribute_Address'],
            'phone_number'      => Yii::$app->params['Attribute_PhoneNumber'],
            'date_issued'       => Yii::$app->params['Attribute_DateIssued'],
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
            $this->customer_number  = Counter::getCustomerNumber(Counter::COUNTER_OF_CUSTOMER);
        }

        $this->date_issued  = Helper::setDateToNoon($this->date_issued);
        $this->area_id      = (!empty($this->village_id)) ? $this->village->area_id : '';

        return true;
    }    
    
    /**
     *
     */
    public function getUrl()
    {
        return Yii::$app->getUrlManager()->createUrl(['customer/view', 'id' => $this->id, 'title' => $this->title]);
    }     
    
    public static function getArrayList(){
        return ArrayHelper::map(Customer::find()->asArray()->all(), 'id','title');
    }
    
    public function sumMonthlyBill() {
        $query = OutletDetail::find()->where([
            'customer_id'=>$this->id,
            'device_status'=>OutletDetail::DEVICE_STATUS_ACTIVE
        ]);
        return $query->asArray()->sum('monthly_bill');
    }     
    
    public function countByUser(){
        $model = Customer::find()->asArray()->where(['created_by'=>Yii::$app->user->id])->all();
        return count($model);
    }
    
    public function getAreaTitle(){
        return $this->area->title;
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
