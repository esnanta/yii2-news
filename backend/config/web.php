<?php

use common\base\BaseController;
use common\behaviors\GlobalAccessBehavior;
use common\behaviors\LoginTimestampBehavior;
use yii\gii\generators\crud\Generator;
use yii\gii\Module;
use yii\web\User;

$config = [
    'homeUrl' => Yii::getAlias('@backendUrl'),
    'controllerNamespace' => 'backend\controllers',
    'defaultRoute' => 'timeline-event/index',
    'components' => [
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'request' => [
            'cookieValidationKey' => env('BACKEND_COOKIE_VALIDATION_KEY'),
            'baseUrl' => env('BACKEND_BASE_URL'),
        ],
        'user' => [
            'class' => User::class,
            'identityClass' => common\models\User::class,
            'loginUrl' => ['sign-in/login'],
            'enableAutoLogin' => true,
            'as afterLogin' => LoginTimestampBehavior::class,
        ],
    ],
    'modules' => [
        'content' => [
            'class' => backend\modules\content\Module::class,
        ],
        'widget' => [
            'class' => backend\modules\widget\Module::class,
        ],
        'file' => [
            'class' => backend\modules\file\Module::class,
        ],
        'system' => [
            'class' => backend\modules\system\Module::class,
        ],
        'translation' => [
            'class' => backend\modules\translation\Module::class,
        ],
        'rbac' => [
            'class' => backend\modules\rbac\Module::class,
            'defaultRoute' => 'rbac-auth-item/index',
        ],
    ],
    'as globalAccess' => [
        'class' => GlobalAccessBehavior::class,
        'rules' => [
            [
                'controllers' => ['sign-in'],
                'allow' => true,
                'roles' => ['?'],
                'actions' => ['login'],
            ],
            [
                'controllers' => ['sign-in'],
                'allow' => true,
                'roles' => ['@'],
                'actions' => ['logout'],
            ],
            [
                'controllers' => ['site'],
                'allow' => true,
                'roles' => ['?', '@'],
                'actions' => ['error'],
            ],
            [
                'controllers' => ['debug/default'],
                'allow' => true,
                'roles' => ['?'],
            ],
            [
                'controllers' => ['user'],
                'allow' => true,
                'roles' => ['administrator'],
            ],
            [
                'controllers' => ['user'],
                'allow' => false,
            ],
            [
                'allow' => true,
                'roles' => ['manager', 'administrator'],
            ],
        ],
    ],
];

if (YII_ENV_DEV) {
    $config['modules']['gii'] = [
        'class' => Module::class,
        'allowedIPs' => ['*'],
        'generators' => [
            'crud' => [
                'class' => Generator::class,
                'baseControllerClass' => BaseController::class,
                'templates' => [
                    'common-starter-kit' => '@common/templates/_gii/templates',
                    'backend-starter-kit' => '@backend/views/_gii/templates',
                ],
                'template' => 'common-starter-kit', // default pilihan
                'messageCategory' => 'backend',
            ],

            'mootensai-crud' => [
                'class' => common\templates\mootensai\crud\Generator::class,
                'baseControllerClass' => BaseController::class,
                'templates' => [
                    'default' => '@common/templates/mootensai/crud/default',
                ],
                'template' => 'default',
            ],
            'mootensai-model' => [
                'class' => common\templates\mootensai\model\Generator::class,
                'templates' => [
                    'default' => '@common/templates/mootensai/model/default',
                ],
                'template' => 'default',
            ],
        ],
    ];
}

return $config;
