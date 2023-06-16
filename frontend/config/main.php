<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

//https://www.yiiframework.com/wiki/755/how-to-hide-frontendweb-in-url-addresses-on-apache
use \yii\web\Request;
$baseUrl = str_replace('/frontend/web', '', (new Request)->getBaseUrl());

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    
    'modules' => [
        'user' => [
            // following line will restrict access to admin controller from frontend application
            'as frontend' => 'dektrium\user\filters\FrontendFilter',
        ],
    ],
    
    'components' => [
        
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'class' => 'common\components\Request',
            'web' => '/frontend/web',
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
        
//        'view' => [
//            'theme' => [
//                'pathMap' => [
//                    '@app/views' => '@app/web/themes/unify263blog/views',
//                    '@dektrium/user/views' => '@app/web/themes/unify263blog/views/user'
//                ],
//                'basePath' => '@app/web/themes/unify263blog',
//                'baseUrl' => '@web/web/themes/unify263blog',
//            ],
//        ],
        
        //BOOSTRAP 4
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/web/themes-b4/views',
                    '@dektrium/user/views' => '@app/web/themes-b4/views/user'
                ],
                'basePath' => '@app/web/themes-b4',
                'baseUrl' => '@web/web/themes-b4',
            ],
        ],
    ],

    'params' => $params,
];
