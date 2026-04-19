<?php

/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/4/14
 * Time: 2:01 PM.
 */

namespace frontend\controllers;

use common\models\Page;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PageController extends Controller
{

    public $layout = '/column1';

    public function actionView($slug)
    {
        $model = Page::find()->where(['slug' => $slug, 'status' => Page::STATUS_PUBLISHED])->one();
        if (!$model) {
            throw new NotFoundHttpException(\Yii::t('frontend', 'Page not found'));
        }

        $viewFile = $model->view ?: 'view';

        return $this->render($viewFile, ['model' => $model]);
    }
}
