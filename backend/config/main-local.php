<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'RC8w_V9_kNcLKuKwjly2K-jzpL0T2vlS',
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
