<?php

namespace common\models;

use Yii;
use \common\models\base\Token as BaseToken;

/**
 * This is the model class for table "tx_token".
 */
class Token extends BaseToken
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['user_id', 'type', 'created_at'], 'integer'],
            [['code', 'type', 'created_at'], 'required'],
            [['code'], 'string', 'max' => 32],
            [['user_id', 'code', 'type'], 'unique', 'targetAttribute' => ['user_id', 'code', 'type'], 'message' => 'The combination of User ID, Code and Type has already been taken.'],
            [['verlock'], 'default', 'value' => '0'],
            [['verlock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }
	
}
