<?php

namespace backend\models;

use Yii;
use \backend\models\base\AccountPayableDetail as BaseAccountPayableDetail;

use common\helper\Helper as Helper;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "tx_account_payable_detail".
 */
class AccountPayableDetail extends BaseAccountPayableDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_id', 'amount'], 'required'],
            [['account_payable_id', 'account_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['amount'], 'safe'], //CHANGE TO SAVE
            [['commentary'], 'string'],
            //[['invoice'], 'default', 'value' => date('y')], //ADD
            [['invoice'], 'string', 'max' => 20],
            //[['invoice'], 'unique', 'targetAttribute' => ['invoice'], 'message' => 'Invoice must be unique.'], //ADD
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
            'id'                    => 'ID',
            'account_payable_id'    => Yii::$app->params['Attribute_AccountPayable'],
            'account_id'            => Yii::$app->params['Attribute_Account'],
            'invoice'               => Yii::$app->params['Attribute_Invoice'],
            'amount'                => Yii::$app->params['Attribute_Amount'],
            'commentary'            => Yii::$app->params['Attribute_Description'],
            
            'created_at'        => Yii::$app->params['Attribute_CreatedAt'],
            'updated_at'        => Yii::$app->params['Attribute_UpdatedAt'],
            'created_by'        => Yii::$app->params['Attribute_CreatedBy'],
            'updated_by'        => Yii::$app->params['Attribute_UpdatedBy'],
            
            'is_deleted'        => 'Deleted',
            'deleted_at'        => Yii::$app->params['Attribute_DeletedAt'],
            'deleted_by'        => Yii::$app->params['Attribute_DeletedBy'],
                      
            'verlock'               => 'Verlock',
        ];
    }    
    
    public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->isNewRecord) {
            $this->invoice          = date('y',$this->accountPayable->date_issued).$this->invoice;             
        }        
        $this->amount       = Helper::removeNumberSeparator($this->amount);
        
        return true;
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
