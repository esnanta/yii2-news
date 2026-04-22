<?php

use common\behaviors\LoginTimestampBehavior;
use common\components\maintenance\Maintenance;
use yii\authclient\clients\Facebook;
use yii\authclient\clients\GitHub;
use yii\authclient\Collection;
use yii\gii\generators\crud\Generator;
use yii\gii\Module;
use yii\web\User;

$config = [
    'homeUrl' => Yii::getAlias('@frontendUrl'),
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'site/index',
    'bootstrap' => ['maintenance'],
    'modules' => [
        'user' => [
            'class' => frontend\modules\user\Module::class,
            'shouldBeActivated' => false,
            'enableLoginByPass' => false,
        ],
    ],
    'components' => [
        'authClientCollection' => [
            'class' => Collection::class,
            'clients' => [
                'github' => [
                    'class' => GitHub::class,
                    'clientId' => env('GITHUB_CLIENT_ID'),
                    'clientSecret' => env('GITHUB_CLIENT_SECRET'),
                ],
                'facebook' => [
                    'class' => Facebook::class,
                    'clientId' => env('FACEBOOK_CLIENT_ID'),
                    'clientSecret' => env('FACEBOOK_CLIENT_SECRET'),
                    'scope' => 'email,public_profile',
                    'attributeNames' => [
                        'name',
                        'email',
                        'first_name',
                        'last_name',
                    ],
                ],
            ],
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@frontend/views' => '@frontend/web/themes/bootstrap4news/views',
                ],
                'basePath' => '@frontend/web/themes/bootstrap4news',
                'baseUrl' => '@web/themes/bootstrap4news',
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'maintenance' => [
            'class' => Maintenance::class,
            'enabled' => function ($app) {
                if ('1' === env('APP_MAINTENANCE')) {
                    return true;
                }

                return 'enabled' === $app->keyStorage->get('frontend.maintenance');
            },
        ],
        'request' => [
            'cookieValidationKey' => env('FRONTEND_COOKIE_VALIDATION_KEY'),
            'baseUrl' => env('FRONTEND_BASE_URL'),
        ],
        'user' => [
            'class' => User::class,
            'identityClass' => common\models\User::class,
            'loginUrl' => ['/user/sign-in/login'],
            'enableAutoLogin' => true,
            'as afterLogin' => LoginTimestampBehavior::class,
        ],
    ],
];

if (YII_ENV_DEV) {
    $config['modules']['gii'] = [
        'class' => Module::class,
        'generators' => [
            'crud' => [
                'class' => Generator::class,
                'messageCategory' => 'frontend',
            ],
        ],
    ];
}

return $config;
