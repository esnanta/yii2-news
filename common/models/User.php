<?php
namespace common\models;

use Yii;
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
    
    public function beforeSave($insert) {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->isNewRecord) {
            $this->username  = $this->email;
        }
        
        return true;
    }     
    
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
            
            $this->saveApplicant();
        }
    }

    private function saveApplicant(){
        if(Yii::$app->params['Feat-Applicant']){

            $applicant = new \backend\models\Applicant;
            $applicant->user_id = $this->id;
            $applicant->save();
            
            if(Yii::$app->params['Feat-Applicant-Academic']){
                $model = new \backend\models\ApplicantAcademic;
                $model->applicant_id = $applicant->id;
                $model->save();
            }   

            if(Yii::$app->params['Feat-Applicant-Almamater']){
                $model = new \backend\models\ApplicantAlmamater;
                $model->applicant_id = $applicant->id;
                $model->save();
            }   

        }                    
    }
}
