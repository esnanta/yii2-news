<?php
namespace common\helper;

use Yii;


class MessageHelper {
    
    public static function getFlashAccessDenied(){
        $message = Yii::$app->getSession()->setFlash('danger', 
                ['message' => Yii::t('app', 'Access Denied! You do not have permission to access this page.')]);
        return $message;
    }
    
    public static function getFlashLoginInfo(){
        $username = '"Guest"';
        if(Yii::$app->user->getIsGuest()==false){
            $tmpUsername    = Yii::$app->user->identity->username;
            $roles          = '';
            $authAssignments = AuthAssignment::find()->where(['user_id'=>Yii::$app->user->id])->all();
            foreach ($authAssignments as $authAssignmentModel) {
//                $roles = '<span class="label label-default">'.$authAssignmentModel.'</span>';
            }
            $username = $tmpUsername.', role '.$roles;
        }
        $message = Yii::$app->getSession()->setFlash('danger', 
                ['message' => Yii::t('app', 'Anda mengakses sebagai '.$username)]);
        return $message;
    }
}