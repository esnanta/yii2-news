<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    
    //https://github.com/yii2mod/yii2-rbac
    'modules' => [
        'rbac' => [
            'class' => 'yii2mod\rbac\Module',
        ],
    ],
    
    'components' => [
        
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'mysql:host=localhost;dbname=yii2-news-update',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'tablePrefix' => 'tx_',
            'enableSchemaCache' => false,
            'schemaCacheDuration' => 3600,// Duration of schema cache.
            'schemaCache' => 'cache',// Name of the cache component used to store schema information
        ],
        
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',  

                //PENGATURAN DI SITE CONTROLLER HARUS DIPINDAH KESINI
                //'login'=>'<module>/<controller>/<action>',
                //https://github.com/yii2mod/yii2-user
                //'site/login' => ['class' => 'yii2mod\user\actions\LoginAction' ],
            ],
                       
        ],  
        
        //https://github.com/yii2mod/yii2-user
        'i18n' => [
            'translations' => [
                'yii2mod.user' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2mod/user/messages',
                ],
                // ...
            ],
        ],
        
        //https://github.com/yii2mod/yii2-user
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-ALLPAGE', 'httpOnly' => true],
            'on afterLogin' => function ($event) {
                $event->identity->updateLastLogin();
            },
        ],
                
        //https://github.com/yii2mod/yii2-rbac        
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['guest', 'user'],
        ],
                
    ],
];
