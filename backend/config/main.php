<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

//https://www.yiiframework.com/wiki/755/how-to-hide-frontendweb-in-url-addresses-on-apache
use \yii\web\Request;
$baseUrl = str_replace('/backend/web', '', (new Request)->getBaseUrl());

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
        
        'request' => [
            'csrfParam' => '_csrf-backend',
            'class' => 'common\components\Request',
            'web'=> '/backend/web',
            'adminUrl' => '/admin',
            'baseUrl' => $baseUrl,
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
                'pathMap' =>
                [
                    '@dektrium/user/views' => '@app/web/themes-admin-unify/dektrium/user',
                    '@dektrium/rbac/views' => '@app/web/themes-admin-unify/dektrium/rbac',
                    '@backend/views' => '@backend/web/themes-admin-unify/views',
                ],
                'basePath' => '@backend/web/themes-admin-unify',
                'baseUrl' => '@web/web/themes-admin-unify',
                
//                [
//                    '@dektrium/user/views' => '@app/web/themes-modernize/views/dektrium/user',
//                    '@dektrium/rbac/views' => '@app/web/themes-modernize/views/dektrium/rbac',
//                    '@app/views' => '@app/web/themes-modernize/views',
//                ],
//                'basePath' => '@app/web/themes-modernize',
//                'baseUrl' => '@web/web/themes-modernize',
                
            ],
        ],
    ],              
    'params' => $params,
];
