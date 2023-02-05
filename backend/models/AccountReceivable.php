<?php

namespace backend\models;

use Yii;
use backend\models\base\AccountReceivable as BaseAccountReceivable;
use backend\models\Counter as Counter;
use common\helper\Helper as Helper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "tx_account_receivable".
 */
class AccountReceivable extends BaseAccountReceivable
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        
        return [
            //TAMBAHAN
            [['invoice'], 'unique', 'targetAttribute' => ['invoice'], 'message' => 'Invoice sudah ada dalam database.'], 
            
            [['staff_id', 'invoice',  'date_issued'], 'required'],
            [['staff_id', 'date_issued', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['description'], 'string'],
            [['claim', 'surcharge', 'penalty', 'total', 'discount', 'payment', 'balance'], 'safe'],
            [['title'], 'string', 'max' => 10],
            [['invoice'], 'string', 'max' => 20],
            [['month_period'], 'string', 'max' => 6],
            [['date_issued'], 'default', 'value' => time()],
            [['verlock', 'is_deleted'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ];        
        
    }
    
    public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if ($this->isNewRecord) {
            $this->month_period = Helper::getMonthPeriod($this->date_issued);
            $this->title = Counter::getSerialNumber(Counter::CODE_OF_ACCOUNT_RECEIVABLE);            
        }
        
        $this->date_issued  = Helper::setDateToNoon($this->date_issued);
        $this->claim        = Helper::removeNumberSeparator($this->claim);
        $this->surcharge    = Helper::removeNumberSeparator($this->surcharge);
        $this->penalty      = Helper::removeNumberSeparator($this->penalty);
        $this->total        = Helper::removeNumberSeparator($this->total);
        $this->discount     = Helper::removeNumberSeparator($this->discount);
        $this->payment      = Helper::removeNumberSeparator($this->payment);
        $this->balance      = Helper::removeNumberSeparator($this->balance);
              
        return true;
    }    
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                => 'ID',
            'staff_id'          => Yii::$app->params['Attribute_Staff'],
            'date_issued'       => Yii::$app->params['Attribute_DateIssued'],
            'title'             => Yii::$app->params['Attribute_Number'],
            'invoice'           => Yii::$app->params['Attribute_Invoice'],
            'month_period'      => Yii::$app->params['Attribute_MonthPeriod'],
            'description'       => Yii::$app->params['Attribute_Description'],
            'claim'             => Yii::$app->params['Attribute_Claim'],
            'surcharge'         => Yii::$app->params['Attribute_Surcharge'],
            'penalty'           => Yii::$app->params['Attribute_Penalty'],
            'total'             => Yii::$app->params['Attribute_Total'],
            'discount'          => Yii::$app->params['Attribute_Discount'],
            'payment'           => Yii::$app->params['Attribute_Payment'],
            'balance'           => Yii::$app->params['Attribute_Balance'],
            
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
     *
     */
    public function getUrl(){
        return Yii::$app->getUrlManager()->createUrl(['account-receivable/view', 'id' => $this->id, 'title' => $this->title]);
    }     
    
    public function getStaffTitle(){
        return $this->staff->title;
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
