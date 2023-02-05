<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

use \backend\models\base\WorkRequest as BaseWorkRequest;

/**
 * This is the model class for table "tx_work_request".
 */
class WorkRequest extends BaseWorkRequest
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['staff_id', 'customer_id', 'date_issued', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['address', 'description'], 'string'],
            [['title'], 'string', 'max' => 10],
            [['invoice'], 'string', 'max' => 20],
            [['customer_title'], 'string', 'max' => 200],
            [['phone_number'], 'string', 'max' => 50],
            [['month_period'], 'string', 'max' => 6],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ]);
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
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnrolment()
    {
        return $this->hasOne(\backend\models\Enrolment::className(), ['customer_id' => 'customer_id']);
    }
	
}
