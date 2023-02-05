<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'user' => [
            // following line will restrict access to profile, recovery, registration and settings controllers from backend
            'as backend' => 'dektrium\user\filters\BackendFilter',
        ],
    ],
    'components' => [
        
        'request'=>[
            'csrfParam' => '_csrf-backend',
            'class' => 'common\components\Request',
            'web'=> '/backend/web',
            'adminUrl' => '/admin'
        ],
        

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'view' => [
            'theme' => [

                'pathMap' => [
                    '@app/views' => '@app/web/themes/dmstr/views',
                    '@dektrium/user/views' => '@app/views/user'
                ],
                'basePath' => '@app/web/themes/dmstr',
                'baseUrl' => '@web/web/themes/dmstr',

                //'pathMap' => ['@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'],
                //'basePath' => '@app/web/themes/dmstr',
                //'baseUrl' => '@web/web/themes/dmstr',                
            ],
        ], 
    ],
    'params' => $params,
];
