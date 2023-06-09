<?php

$params = array_merge(
        require __DIR__ . '/../../common/config/params.php',
        require __DIR__ . '/../../common/config/params-local.php',
        require __DIR__ . '/params.php',
        require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'controllerMap' => [
        'fixture' => [
            'class' => \yii\console\controllers\FixtureController::class,
            'namespace' => 'common\fixtures',
        ],
    ],
    'components' => [
        
        /*
         * HARUS PASANG USER CLASS DI SINI SUPAYA BISA
         * EKSEKUSI PERINTAH BERIKUT.
         * TIDAK TERTERA DI : https://github.com/yii2mod/yii2-user
         *      ./yii user/create <EMAIL> <USER> <PASS>
         *      
         */
        'user' => [
            'class' => 'yii2mod\user\models\UserModel',
        ],

        'log' => [
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    
    //https://github.com/yii2mod/yii2-user
    'modules' => [
        'user' => [
            'class' => 'yii2mod\user\ConsoleModule',
        ],
    ],
    'params' => $params,
];
