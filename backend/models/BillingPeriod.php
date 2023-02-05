<?php

namespace backend\models;

use Yii;
use backend\models\Billing as Billing;
/**
 * This is the model class for table "tx_billing".
 */
class BillingPeriod extends Billing
{
    
    public $validity_period;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        
        return [
            [['customer_id', 'area_id', 'date_issued', 'date_due', 'billing_type', 'payment_status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['validity_period'], 'safe'],//TAMBAHAN
            [['amount'], 'safe'], //EDIT
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
            
            'validity_period'   => 'Periode Tagihan',
            
            'id'                => 'ID',
            'customer_id'       => Yii::$app->params['Attribute_Customer'],
            'title'             => Yii::$app->params['Attribute_Title'],
            'invoice'           => Yii::$app->params['Attribute_Invoice'],
            'amount'            => Yii::$app->params['Attribute_Amount'],
            'date_issued'       => Yii::$app->params['Attribute_DateIssued'],
            'date_due'          => Yii::$app->params['Attribute_DateDue'],
            'month_period'      => Yii::$app->params['Attribute_MonthPeriod'],
            'billing_type'      => Yii::$app->params['Attribute_Type'],
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
    
}
