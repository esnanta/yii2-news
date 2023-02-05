<?php

namespace backend\models;

use Yii;
use \backend\models\base\AccountType as BaseAccountType;

/**
 * This is the model class for table "tx_account_type".
 */
class AccountType extends BaseAccountType
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['description'], 'string'],
            [['created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'deleted_by', 'verlock'], 'integer'],
            [['token'], 'string', 'max' => 10],
            [['title'], 'string', 'max' => 100],
            [['token'], 'unique'],
            [['verlock', 'is_deleted'], 'default', 'value' => '0'],
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
            'token'             => Yii::$app->params['Attribute_Token'],
            'title'             => Yii::$app->params['Attribute_Title'],
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
