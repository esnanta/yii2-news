<?php

namespace backend\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

use \backend\models\base\Receivable as BaseReceivable;
use backend\models\Counter as Counter;
use common\helper\Helper as Helper;

/**
 * This is the model class for table "tx_receivable".
 */
class Receivable extends BaseReceivable
{
    
    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'customer',
            'staff',
            'receivableDetails',
            'enrolment' //TAMBAH
        ];
    }    
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'staff_id', 'invoice'], 'required'], //TAMBAHAN

            [['customer_id', 'staff_id', 'date_issued', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['description'], 'string'],
            [['claim', 'surcharge', 'penalty', 'total', 'discount', 'payment', 'balance'], 'safe'],
            [['title'], 'string', 'max' => 10],
            [['month_period'], 'string', 'max' => 6],
            
            [['invoice'], 'string', 'max' => 10],
            [['invoice'], 'unique'],
            [['invoice'], 'validateInvioce'], //ADD
            
            [['verlock', 'is_deleted'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']          
        ];          
    }
	
    public function validateInvioce($attribute, $params, $validator)
    {
        $invoice = date('y',$this->date_issued).$this->invoice;
        $check = Receivable::find()->where(['invoice'=> $invoice])->one();
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
    
    public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->isNewRecord) {
            $this->title        = Counter::getSerialNumber(Counter::CODE_OF_RECEIVABLE);
            $this->invoice      = date('y',$this->date_issued).$this->invoice;             
        }
     
        $this->date_issued      = Helper::setDateToNoon($this->date_issued);
        $this->month_period     = Helper::getMonthPeriod($this->date_issued);
        $this->claim            = Helper::removeNumberSeparator($this->claim);
        $this->surcharge        = Helper::removeNumberSeparator($this->surcharge);
        $this->penalty          = Helper::removeNumberSeparator($this->penalty);
        $this->total            = Helper::removeNumberSeparator($this->total);
        $this->discount         = Helper::removeNumberSeparator($this->discount);
        $this->payment          = Helper::removeNumberSeparator($this->payment);
        $this->balance          = Helper::removeNumberSeparator($this->balance);
        
        return true;
    }       
    
    public function getUrl()
    {
        return Yii::$app->getUrlManager()->createUrl(['receivable/view', 'id' => $this->id, 'title' => $this->title]);
    }       
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnrolment()
    {
        return $this->hasOne(\backend\models\Enrolment::className(), ['customer_id' => 'customer_id']);
    }        
    
    public function getStaffTitle(){
        return $this->staff->title;
    }  
    
    public function getReceivableDetailOverdue(){
        $modelDetails = ReceivableDetail::find()->asArray()->where(['receivable_id'=>$this->id])->all();
        $value = '';
        foreach ($modelDetails as $modelDetailItemData) {
            $dateDue = Yii::$app->formatter->format($modelDetailItemData['date_due'],'date');
            $value = $value.$dateDue.'('.$modelDetailItemData['overdue'].')'.' ; ';
        }
        return $value;
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
