<?php

namespace backend\controllers;

use yii\web\Controller;

/**
 * Site controller.
 */
class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function beforeAction($action)
    {
        $this->layout = \Yii::$app->user->isGuest || !\Yii::$app->user->can('loginToBackend') ? 'base' : 'common';

        return parent::beforeAction($action);
    }
}
