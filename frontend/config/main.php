<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

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
                                     '@app/views' => '@app/web/themes/bootstrap4news/views',
                                     '@dektrium/user/views' => '@app/web/themes/bootstrap4news/views/user'
                                 ],
                                 'basePath' => '@app/web/themes/bootstrap4news',
                                 'baseUrl' => '@web/web/themes/bootstrap4news',
                
            ],
        ],
        
    ],
    'params' => $params,
];
