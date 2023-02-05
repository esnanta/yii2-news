<?php

namespace backend\models;

use Yii;
use backend\models\ValidityDetail as ValidityDetail;

/**
 * This is the model class for table "tx_validity_detail".
 */
class ValidityDetailPeriod extends ValidityDetail
{
    public $validity_period;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
            //[['validity_id'], 'required'], //TAMBAHAN
            [['validity_period'], 'required'], //TAMBAHAN
            [['amount'], 'safe'],
            [['validity_period'], 'safe'],//TAMBAHAN
            
            [['validity_id', 'customer_id', 'device_status', 'billing_status', 'date_due', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['description'], 'string'],
            [['month_period'], 'string', 'max' => 6],
            [['title'], 'string', 'max' => 10],
            //[['validity_id', 'customer_id'], 'checkUniq'], //TAMBAHAN                
                
            [['verlock', 'is_deleted'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator'],          
        ];          
        
    }  
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'validity_period'   => 'Validasi Periode',

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
   
}
