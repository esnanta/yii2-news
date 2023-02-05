<?php
return [
    
    'name' => 'Lhokseumawe Puja Tv',
    
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    
    'timeZone' => 'Asia/Jakarta',
    
    'components' => [
        
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],        
        
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['guest'], // your define roles
        ],        
                
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',                
            ],
        ], 
        
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'locale' => 'en-US', 
            //'dateFormat' => 'dd-MM-yyyy',
            //'thousandSeparator' => ',',
            //'decimalSeparator' => '.',              
        ],  
        
        'assetManager' => [
            'bundles' => [
                'dosamigos\google\maps\MapAsset' => [
                    'options' => [
                        'key' => 'AIzaSyAZNe15CKz-4N6xZIwAEsZD8i03FFBVy08',
                        'language' => 'id',
                        'version' => '3.1.18'
                    ]
                ]
            ]
        ],        
 
    ],
    
    'modules' => [

        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => true,
            'enablePasswordRecovery' => true,
            'enableRegistration' => false,
            'confirmWithin' => 21600,
            'cost' => 12,
            'admins' => ['admin'],            
            // you will configure your module inside this file
            // or if need different configuration for frontend and backend you may
            // configure in needed configs  
            'modelMap' => [
                'User' => 'common\models\User',
            ],  
        ],       
        
        'rbac' => 'dektrium\rbac\RbacWebModule',
        
        //see https://github.com/warrence/yii2-kartikgii
        'gridview' => [
            'class' => '\kartik\grid\Module',
        ],
        
        //see https://github.com/warrence/yii2-kartikgii
        'datecontrol' =>  [
            'class' => 'kartik\datecontrol\Module',

            // format settings for displaying each date attribute (ICU format example)
            'displaySettings' => [
                kartik\datecontrol\Module::FORMAT_DATE => 'dd-MM-yyyy',
                kartik\datecontrol\Module::FORMAT_TIME => 'HH:mm:ss a',
                kartik\datecontrol\Module::FORMAT_DATETIME => 'dd-MM-yyyy HH:mm:ss a', 
            ],

            // format settings for saving each date attribute (PHP format example)
            'saveSettings' => [
                kartik\datecontrol\Module::FORMAT_DATE => 'php:U', // saves as unix timestamp
                kartik\datecontrol\Module::FORMAT_TIME => 'php:H:i:s',
                kartik\datecontrol\Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
            ],

            // set your display timezone
            'displayTimezone' => 'Asia/Jakarta',

            // set your timezone for date saved to db
            'saveTimezone' => 'Asia/Jakarta',

            // automatically use kartik\widgets for each of the above formats
            'autoWidget' => true,

            // use ajax conversion for processing dates from display format to save format.
            'ajaxConversion' => false,

            // default settings for each widget from kartik\widgets used when autoWidget is true
            'autoWidgetSettings' => [
                kartik\datecontrol\Module::FORMAT_DATE => ['type'=>1, 'pluginOptions'=>['autoclose'=>true]], // example
                kartik\datecontrol\Module::FORMAT_DATETIME => [], // setup if needed
                kartik\datecontrol\Module::FORMAT_TIME => [], // setup if needed
            ],
            
            'widgetSettings' => [
                kartik\datecontrol\Module::FORMAT_DATE => [
                    'class' => 'yii\jui\DatePicker', // example
                    
                    'options' => [
                        'dateFormat' => 'php:d-M-Y',
                        'options' => ['class' => 'form-control'],
                        'todayHighlight' => true,
                    ]
                ],
            ]
        ],
        
        // If you use tree table
        // see settings on http://demos.krajee.com/tree-manager#module
        'treemanager' =>  [
            'class' => '\kartik\tree\Module',
        ]     
    ],    
];
