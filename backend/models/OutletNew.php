<?php

namespace backend\models;

use Yii;
use \backend\models\Outlet as Outlet;

/**
 * This is the model class for table "tx_outlet".
 */
class OutletNew extends Outlet
{
    public $enrolment_type;
    public $date_start;
    public $date_end;
    
    public $date_effective;
    public $billing_cycle;
    public $network_tags_title;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
            [['enrolment_type','date_start','date_end','date_effective'], 'integer'],
            [['billing_cycle'], 'string', 'max' => 2],
            
            [['staff_id', 'assembly_type', 'date_issued', 'invoice', 
                'enrolment_type', 'date_start', 'date_end',
                'date_effective', 'billing_cycle','network_tags_title'], 'required'], //TAMBAHAN
            
            [['customer_id', 'staff_id', 'date_issued', 'date_assembly', 'billing_status', 'assembly_type', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['claim','network_tags_title','date_effective', 'billing_cycle'], 'safe'],
            
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
    
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            
            'enrolment_type'        => Yii::$app->params['Attribute_Type'],
            'date_start'            => Yii::$app->params['Attribute_DateStart'],
            'date_end'              => Yii::$app->params['Attribute_DateEnd'],
            
            'network_tags_title'    => 'Lokasi',
            'date_effective'        => Yii::$app->params['Attribute_DateEffective'],
            'billing_cycle'         => Yii::$app->params['Attribute_BillingCycle'],
            
            'id'                => 'ID',
            'customer_id'       => Yii::$app->params['Attribute_Customer'],
            'staff_id'          => Yii::$app->params['Attribute_Staff'],
            'title'             => Yii::$app->params['Attribute_Title'],
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

}
