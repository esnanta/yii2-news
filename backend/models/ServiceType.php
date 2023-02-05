<?php

namespace backend\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

use \backend\models\base\ServiceType as BaseServiceType;

/**
 * This is the model class for table "tx_service_type".
 */
class ServiceType extends BaseServiceType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['description'], 'string'],
            [['create_time', 'create_by', 'update_time', 'update_by', 'verlock'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                => 'ID',
            'title'             => Yii::$app->params['Attribute_Title'],
            'description'       => Yii::$app->params['Attribute_Description'],
            'create_time'       => Yii::$app->params['Attribute_CreateTime'],
            'update_time'       => Yii::$app->params['Attribute_UpdateTime'],
            'create_by'         => Yii::$app->params['Attribute_CreateBy'],
            'update_by'         => Yii::$app->params['Attribute_UpdateBy'],
            'verlock'           => 'Verlock',
        ];
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
