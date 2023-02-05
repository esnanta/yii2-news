<?php
namespace common\models;

use dektrium\user\models\User as BaseUser;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends BaseUser
{
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            $this->getDb()
                ->createCommand()
                ->insert('{{%auth_assignment}}', [
                    'item_name' => 'reguler',
                    'user_id' => $this->id,
                    'created_at' => time(),
                ])
                ->execute();
        }
    }    
}
