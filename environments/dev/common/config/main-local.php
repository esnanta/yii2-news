<?php

$config = [
    'components' => [
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'mysql:host=localhost;dbname=not-selected',
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
    $config['modules']['gii'] = [
        'class' => \yii\gii\Module::class,
        'generators' => [ //here
//            'crud' => [ // generator name
//                'class' => 'yii\gii\generators\crud\Generator', // generator class
//                'templates' => [ //setting for out templates
//                    'adminlte' => '@backend/templates/crud/adminlte', // template name => path to template
//                    'dmstr' => '@backend/templates/crud/dmstr', // template name => path to template
//                ]
//            ], 
            
//            'kartikgii-crud' => [ // generator name
//                'class' => 'warrence\kartikgii\crud\Generator', // generator class
//                'templates' => [ //setting for out templates
//                    'kartikgii' => '@backend/templates/crud/kartikgii', // template name => path to template
//                ]
//            ],    
            
            'mootensai-crud' => [ // generator name
                'class' => 'mootensai\enhancedgii\crud\Generator', // generator class
                'templates' => [ //setting for out templates
                    'mootensai' => '@backend/templates/crud/mootensai', // template name => path to template
                ]
            ]               
            
        ]
    ];
}

return $config;
