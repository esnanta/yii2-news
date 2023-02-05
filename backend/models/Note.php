<?php

namespace backend\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

use \backend\models\base\Note as BaseNote;
use common\helper\Helper as Helper;

/**
 * This is the model class for table "tx_note".
 */
class Note extends BaseNote
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['note_type_id', 'staff_id', 'date_issued', 'date_due', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 100],
            [['verlock', 'is_deleted'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }
    
    public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->date_issued  = Helper::setDateToNoon($this->date_issued);
        $this->date_due     = Helper::setDateToNoon($this->date_due);
        
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
            'note_type_id'      => Yii::$app->params['Attribute_Type'],
            'title'             => Yii::$app->params['Attribute_Title'],
            'description'       => Yii::$app->params['Attribute_Description'],
            'date_issued'       => Yii::$app->params['Attribute_DateIssued'],
            'date_due'          => Yii::$app->params['Attribute_DateDue'],
            
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
	          
    public function getUrl()
    {
        return Yii::$app->getUrlManager()->createUrl(['note/view', 'id' => $this->id, 'title' => $this->title]);
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
