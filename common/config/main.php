<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    
    //Yii::$app->name
    'name' => 'ARSIP SMAN MBA',
    'timeZone' => 'Asia/Jakarta',
    
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    
    'components' => [
        
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'mysql:host=localhost;dbname=yii2-escyber13',
            //'dsn' => 'mysql:host=localhost;dbname=zttrhcuc_smanmba',
            //'dsn' => 'mysql:host=localhost;dbname=zttrhcuc_liniwarta',
            //'dsn' => 'mysql:host=localhost;dbname=yii2-escyber13_mail',
            //'dsn' => 'mysql:host=localhost;dbname=yii2-arsip',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'tablePrefix' => 'tx_',
            'enableSchemaCache' => false,
            'schemaCacheDuration' => 3600,// Duration of schema cache.
            'schemaCache' => 'cache',// Name of the cache component used to store schema information
        ],
        
        'authManager'  => [
            'class'        => 'dektrium\rbac\components\DbManager',
            'defaultRoles' => ['guest'],
        ],  
        
//        'authManager' => [
//            'class' => 'yii\rbac\DbManager',
//            'defaultRoles' => ['guest'], // your define roles
//        ],  
        
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@app/mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                //'host' => 'smtp.gmail.com', // your host, here using fake email server (https://mailtrap.io/). You can use gmail: 'host' => 'smtp.gmail.com'
                'host' => 'mail.smanmba.sch.id', // your host, here using fake email server (https://mailtrap.io/). You can use gmail: 'host' => 'smtp.gmail.com'
                'username' => 'no-reply@smanmba.sch.id',
                'password' => 'noreply3a21',
                'encryption' => 'tls',
            ],
        ],
        
        
        //REMOVE THIS IF WANT 2 SESSION
        //THEN UNCOMMENT BACKEND AND FRONTEND
        'user' => [
            'identityCookie' => [
                'name'     => '_allIdentityhere',
                'path'     => '/',
                'httpOnly' => true,
            ],
        ],
        'session' => [
            'name' => 'my-ALL-SESSID',
            'cookieParams' => [
                'httpOnly' => true,
                'path'     => '/',
            ],
        ],          
        
        'cache' => [
            'class' => 'yii\caching\FileCache',
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
        
        'assetManager' => [
            'bundles' => [
                'dosamigos\google\maps\MapAsset' => [
                    'options' => [
                        'key' => 'AIzaSyAHGeVcgIBNn9znRnlwmOh6j4x9TEFFOGk',
                        'language' => 'id',
                        'version' => '3.1.18'
                    ]
                ]
            ]
        ],       
        
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'locale' => 'en-US', 
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',              
        ],          
 
    ],
    
    'modules' => [
        
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => false,
            'enablePasswordRecovery' => false,
            'enableRegistration' => false,
            'enableConfirmation' => false,
            'confirmWithin' => 21600,
            'cost' => 12,
            'admins' => ['admin'],            
            // you will configure your module inside this file
            // or if need different configuration for frontend and backend you may
            // configure in needed configs      
            'modelMap' => [
                'User' => 'common\models\User',
            ],     
            'controllerMap' => [
                'registration' => [
                    'class' => \dektrium\user\controllers\RegistrationController::className(),
                    'on ' . \dektrium\user\controllers\RegistrationController::EVENT_AFTER_REGISTER => function ($e) {
                        Yii::$app->response->redirect(array('/user/security/login'))->send();
                        Yii::$app->end();
                    },
                    'class' => \dektrium\user\controllers\RegistrationController::className(),
                    'on ' . \dektrium\user\controllers\RegistrationController::EVENT_AFTER_CONFIRM => function ($e) {
                        Yii::$app->response->redirect(array('/user/security/login'))->send();
                        Yii::$app->end();
                    },
                    'class' => \dektrium\user\controllers\RegistrationController::className(),
                    'on ' . \dektrium\user\controllers\RegistrationController::EVENT_AFTER_RESEND => function ($e) {
                        Yii::$app->response->redirect(array('/user/security/login'))->send();
                        Yii::$app->end();
                    }    
                    
                ],                       
            ], 
                  
            //CHECK MAILER IN MAIN-LOCAL.PHP
            'mailer' => [
                'viewPath' => '@common/mail',
                'sender' => ['no-reply@smanmba.sch.id' => 'PSB SMAN Modal Bangsa Arun']
            ]
          
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
        ],
        
        //http://demos.krajee.com/social#installation
        'social' => [
            // the module class
            'class' => 'kartik\social\Module',
            // the global settings for the Disqus widget
            'disqus' => [
                'settings' => ['shortname' => 'warta-smanmba-1'] // default settings
            ],
            // the global settings for the Facebook plugins widget
            'facebook' => [
                'appId' => 'FACEBOOK_APP_ID',
                'secret' => 'FACEBOOK_APP_SECRET',
            ],
            // the global settings for the Google+ Plugins widget
            'google' => [
                'clientId' => 'GOOGLE_API_CLIENT_ID',
                'pageId' => 'GOOGLE_PLUS_PAGE_ID',//GOOGLE_PLUS_PAGE_ID
                'profileId' => 'GOOGLE_PLUS_PROFILE_ID',//GOOGLE_PLUS_PROFILE_ID
            ],
            // the global settings for the Google Analytics plugin widget
            'googleAnalytics' => [
                'id' => 'TRACKING_ID',
                'domain' => 'TRACKING_DOMAIN',
            ],
            // the global settings for the Twitter plugin widget
            'twitter' => [
                'screenName' => 'TWITTER_SCREEN_NAME'
            ],
            // the global settings for the GitHub plugin widget
            'github' => [
                'settings' => ['user' => 'GITHUB_USER', 'repo' => 'GITHUB_REPO']
            ],
        ],        
        
        
    ], 
];
