<?php

namespace backend\models;

use Yii;
use \backend\models\base\User as BaseUser;

/**
 * This is the model class for table "tx_user".
 */
class User extends BaseUser
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['status', 'created_at', 'updated_at', 'last_login'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['email'], 'unique'],
            [['username'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }
    public static function getName($_id){ 
        //https://www.yiiframework.com/doc/guide/2.0/en/caching-data
        //$db = Yii::$app->db;// or Category::getDb()
        $value = User::getDb()->cache(function () use ($_id) {
            $model = User::find()->where(['id' => $_id])->one();
            return $model->username;
        });       

       return $value;           
        
    } 
}
