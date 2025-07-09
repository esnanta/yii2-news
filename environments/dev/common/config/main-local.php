<?php

use yii\db\Connection;
use yii\debug\Module;
use yii\symfonymailer\Mailer;

$config = [
    'components' => [
        'db' => [
            'class' => Connection::class,
            'dsn' => 'mysql:host=localhost;dbname=yii2_news',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8mb4',
        ],
        'mailer' => [
            'class' => Mailer::class,
            'viewPath' => '@common/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
            // You have to set
            //
            // 'useFileTransport' => false,
            //
            // and configure a transport for the mailer to send real emails.
            //
            // SMTP server example:
            //    'transport' => [
            //        'scheme' => 'smtps',
            //        'host' => '',
            //        'username' => '',
            //        'password' => '',
            //        'port' => 465,
            //        'dsn' => 'native://default',
            //    ],
            //
            // DSN example:
            //    'transport' => [
            //        'dsn' => 'smtp://user:pass@smtp.example.com:25',
            //    ],
            //
            // See: https://symfony.com/doc/current/mailer.html#using-built-in-transports
            // Or if you use a 3rd party service, see:
            // https://symfony.com/doc/current/mailer.html#using-a-3rd-party-transport
        ],
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => Module::class,
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii']['class'] = 'yii\gii\Module';
    $config['modules']['gii']['generators'] = [
        'kartikgii-crud' => [ // generator name
            'class' => 'common\templates\kartikgii\crud\Generator',
            'templates' => [
                'kartikgii' => '@common/templates/kartikgii/crud/default',
            ],
        ],

        'mootensai-crud' => [ // generator name
            'class' => 'common\templates\mootensai\crud\Generator',
            'templates' => [
                'mootensai-crud' => '@common/templates/mootensai/crud/default',
            ],
        ],

        'mootensai-model' => [ // generator name
            'class' => 'common\templates\mootensai\model\Generator',
            'templates' => [
                'mootensai-model' => '@common/templates/mootensai/model/default',
            ],
        ],
    ];
}

return $config;
