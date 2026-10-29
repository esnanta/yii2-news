<?php

namespace common\base;

use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class BaseController extends Controller
{
    /**
     * @throws ForbiddenHttpException
     */
    protected function checkAccess(string $permission, $model = null): void
    {
        if (!Yii::$app->user->can($permission, $model ? ['model' => $model] : [])) {
            throw new ForbiddenHttpException(
                Yii::t('app', 'Access Denied! You do not have permission to access this page.')
            );
        }
    }
}
