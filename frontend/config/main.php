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

/*//////////////////////////////////////////////////////////////////////////////
EDIT JUGA THEME PARAM-LOCAL COMMON
 *///////////////////////////////////////////////////////////////////////////////

//                 'pathMap' => [
//                     '@app/views' => '@app/web/themes/home14/views',
//                     '@dektrium/user/views' => '@app/web/themes/home14/views/user',
//                 ],
//                 'basePath' => '@app/web/themes/home14',
//                 'baseUrl' => '@web/web/themes/home14',

//               'pathMap' => [
//                                   '@app/views' => '@app/web/themes/blog19/views',
//                                   '@dektrium/user/views' => '@app/web/themes/blog19/views/user'
//                               ],
//                               'basePath' => '@app/web/themes/blog19',
//                               'baseUrl' => '@web/web/themes/blog19',
//                
//                                'pathMap' => [
//                                    '@app/views' => '@app/web/themes/college/views',
//                                    '@dektrium/user/views' => '@app/web/themes/college/views/user'
//                                ],
//                                'basePath' => '@app/web/themes/college',
//                                'baseUrl' => '@web/web/themes/college',

//               'pathMap' => [
//                                   '@app/views' => '@app/web/themes/unify196/views',
//                                   '@dektrium/user/views' => '@app/web/themes/unify196/views/user'
//                               ],
//                               'basePath' => '@app/web/themes/unify196',
//                               'baseUrl' => '@web/web/themes/unify196',

//                'pathMap' => [
//                                    '@app/views' => '@app/web/themes/home8/views',
//                                    '@dektrium/user/views' => '@app/web/themes/home8/views/user'
//                                ],
//                                'basePath' => '@app/web/themes/home8',
//                                'baseUrl' => '@web/web/themes/home8',
                
                
                 'pathMap' => [
                                     '@app/views' => '@app/web/themes/unify263blog/views',
                                     '@dektrium/user/views' => '@app/web/themes/unify263blog/views/user'
                                 ],
                                 'basePath' => '@app/web/themes/unify263blog',
                                 'baseUrl' => '@web/web/themes/unify263blog',                
                
            ],
        ],
        
    ],
    'params' => $params,
];
