<?php

$config = [
    'components' => [
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'mysql:host=localhost;dbname=yii2-news',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
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
        'class' => \yii\debug\Module::class,
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii']['class'] = 'yii\gii\Module';
    $config['modules']['gii']['generators'] = [

            'kartikgii-crud' => [ // generator name
                'class' => 'common\templates\kartikgii\crud\Generator', // generator class
                'templates' => [ //setting for out templates
                    'kartikgii' => '@common/templates/kartikgii/crud/default', // template name => path to template
                ]
            ],    
            
            'mootensai-crud' => [ // generator name
                'class' => 'common\templates\mootensai\crud\Generator', // generator class
                'templates' => [ //setting for out templates
                    'mootensai-crud' => '@common/templates/mootensai/crud/default', // template name => path to template
                ]
            ],
        
            'mootensai-model' => [ // generator name
                'class' => 'common\templates\mootensai\model\Generator', // generator class
                'templates' => [ //setting for out templates
                    'mootensai-model' => '@common/templates/mootensai/model/default', // template name => path to template
                ]
            ],
        
            'thtmorais-test' => [ // generator name
                'class' => 'thtmorais\test\unit\Generator', // generator class
                'templates' => [ //setting for out templates
                    'yii2-test' => 'vendor/thtmorais/yii2-test/src/unit/default', // template name => path to template
                ]
            ] 
        
    ];
}

return $config;
