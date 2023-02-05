<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
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
        'class' => 'yii\gii\Module',
        'generators' => [ //here
//            'crud' => [ // generator name
//                'class' => 'yii\gii\generators\crud\Generator', // generator class
//                'templates' => [ //setting for out templates
//                    'adminlte' => '@backend/templates/crud/adminlte', // template name => path to template
//                    'dmstr' => '@backend/templates/crud/dmstr', // template name => path to template
//                ]
//            ], 
            
            'kartikgii-crud' => [ // generator name
                'class' => 'warrence\kartikgii\crud\Generator', // generator class
                'templates' => [ //setting for out templates
                    'kartikgii' => '@backend/templates/crud/kartikgii', // template name => path to template
                ]
            ],    
            
//            'mootensai-crud' => [ // generator name
//                'class' => 'mootensai\enhancedgii\crud\Generator', // generator class
//                'templates' => [ //setting for out templates
//                    'mootensai' => '@backend/templates/crud/mootensai', // template name => path to template
//                ]
//            ]               
            
        ]
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
