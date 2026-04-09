<?php

namespace common\base;

use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class BaseController extends Controller
{
    /**
     * @param mixed|null $model
     *
     * @throws ForbiddenHttpException
     */
    protected function checkAccess(string $permission, mixed $model = null): void
    {
        if (!\Yii::$app->user->can($permission, $model ? ['model' => $model] : [])) {
            throw new ForbiddenHttpException(
                \Yii::t('app', 'Access Denied! You do not have permission to access this page.')
            );
        }
    }
}
