<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),

    'controllerNamespace' => 'frontend\controllers',
    
    'bootstrap' => ['log'],    
    
    'modules' => [
        'user' => [
            // following line will restrict access to admin controller from frontend application
            'as frontend' => 'dektrium\user\filters\FrontendFilter',
        ],
    ],    
    
    'components' => [
        
        'request'=>[
            'class' => 'common\components\Request',
            'web'=> '/frontend/web'
        ],
                
        'user' => [
            'identityCookie' => [
                'name'     => '_frontendIdentity',
                'path'     => '/',
                'httpOnly' => true,
            ],
        ],
        'session' => [
            'name' => 'FRONTENDSESSID',
            'cookieParams' => [
                'httpOnly' => true,
                'path'     => '/',
            ],
            
            'class' => 'yii\web\DbSession',
            'sessionTable' => 'tx_session',
        ],          
        
//        'user' => [
//            'identityClass' => 'common\models\User',
//            'enableAutoLogin' => true,
//        ],

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                ],
            ],
        ],
        
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /*
         * PINDAH KE COMMON
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
        
        'view' => [
            'theme' => [

                // 'pathMap' => [
                //     '@app/views' => '@app/web/themes/home14/views',
                //     '@dektrium/user/views' => '@app/views/user'
                // ],
                // 'basePath' => '@app/web/themes/home14',
                // 'baseUrl' => '@web/web/themes/home14',
                
//                'pathMap' => [
//                    '@app/views' => '@app/web/themes/portfolio7/views',
//                    '@dektrium/user/views' => '@app/views/user'
//                ],
//                'basePath' => '@app/web/themes/portfolio7',
//                'baseUrl' => '@web/web/themes/portfolio7',
                
                'pathMap' => [
                    '@app/views' => '@app/web/themes/lawyer/views',
                    '@dektrium/user/views' => '@app/views/user'
                ],
                'basePath' => '@app/web/themes/lawyer',
                'baseUrl' => '@web/web/themes/lawyer',                

//                'pathMap' => ['@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'],
//                'basePath' => '@app/web/themes/dmstr',
//                'baseUrl' => '@web/web/themes/dmstr',                
            ],
        ],         
        
    ],
    'params' => $params,
];
