<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace backend\controllers;

use dektrium\user\controllers\AdminController as BaseAdminController;
use dektrium\user\Module;

use yii;
use yii\helpers\Url;

use backend\models\Profile;

/**
 * AdminController allows you to administrate users.
 *
 * @property Module $module
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com
 */
class AdminController extends BaseAdminController
{
    /**
     * Updates an existing User model.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionUpdate($id,$title=null)
    {
        if(Yii::$app->user->can('update-profile')){
            Url::remember('', 'actions-redirect');
            $user = $this->findModel($id);
            $user->scenario = 'update';
            $event = $this->getUserEvent($user);

            $this->performAjaxValidation($user);

            $this->trigger(self::EVENT_BEFORE_UPDATE, $event);
            if ($user->load(\Yii::$app->request->post()) && $user->save()) {

                if(!empty($user->password)){
                    $user->save();
                    Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'User password has been updated'));
                    $this->trigger(self::EVENT_AFTER_UPDATE, $event);
                    $this->refresh();                
                }
                else{
                    Yii::$app->getSession()->setFlash('warning', \Yii::t('user', 'Can not updated blank password.'));
                }

                return $this->redirect(['/profile/view', 'id'=>$user->id]);
            }

            $user->password = '';//SET TO BLANK
            return $this->render('update', [
                'user' => $user,
            ]);
        }
        else{
            Yii::$app->getSession()->setFlash('danger', ['message' => Yii::t('app', Helper::getAccessDenied())]);
            throw new ForbiddenHttpException;
        }        
            
    }

}
