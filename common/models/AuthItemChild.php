<?php

namespace common\models;

use Yii;
use \common\models\base\AuthItemChild as BaseAuthItemChild;

/**
 * This is the model class for table "tx_auth_item_child".
 */
class AuthItemChild extends BaseAuthItemChild
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['parent', 'child'], 'required'],
            [['parent', 'child'], 'string', 'max' => 64]
        ]);
    }
	
}
