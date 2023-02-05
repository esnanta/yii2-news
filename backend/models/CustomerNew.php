<?php

namespace backend\models;

use Yii;
use backend\models\Customer as Customer;
use backend\models\Counter as Counter;
use backend\models\Gmap as Gmap;
use backend\models\Enrolment as Enrolment;
/**
 * This is the model class for table "tx_customer".
 */
class CustomerNew extends Customer
{
    
    public $latitude;
    public $longitude;
    
    public $enrolment_title;
    public $network_id;
    public $billing_cycle;
    public $date_effective;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
            [['date_issued'],'safe'],
            
            [['latitude', 'longitude'], 'string', 'max' => 30],
            
            [['network_id', 'date_effective'], 'integer'],
            [['billing_cycle'], 'string', 'max' => 2],
            [['enrolment_title'], 'string', 'max' => 10],
            
            [['area_id', 'village_id', 'gender_status', 'date_issued', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['address', 'description'], 'string'],
            [['customer_number'], 'string', 'max' => 10],
            [['identity_number', 'title', 'phone_number'], 'string', 'max' => 50],
            [['customer_number'], 'unique'],                
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
            
            'latitude'          => Yii::$app->params['Attribute_Latitude'],
            'longitude'         => Yii::$app->params['Attribute_Longitude'],            
            
            'network_id'        => Yii::$app->params['Attribute_Network'],
            'date_effective'    => Yii::$app->params['Attribute_DateEffective'],
            'billing_cycle'     => Yii::$app->params['Attribute_BillingCycle'],            
            
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
 
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if(!empty($this->latitude) && !empty($this->longitude)){
            $gmap = new Gmap;
            $gmap->customer_id  = $this->id;
            $gmap->latitude     = $this->latitude;
            $gmap->longitude    = $this->longitude;
            $gmap->save();
        }
        
        if(!empty($this->network_id) && !empty($this->billing_cycle) && !empty($this->date_effective)){
            $enrolment = new Enrolment;
            $enrolment->title           = Counter::getCustomerNumber(Counter::COUNTER_OF_ENROLMENT);
            $enrolment->customer_id     = $this->id;
            $enrolment->network_id      = $this->network_id;
            $enrolment->billing_cycle   = $this->billing_cycle;
            $enrolment->date_effective  = $this->date_effective;
            $enrolment->save();
        }
        
    }    
}
