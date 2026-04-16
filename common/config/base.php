<?php

use common\behaviors\FileStorageLogBehavior;
use common\components\filesystem\LocalFlysystemBuilder;
use common\components\keyStorage\KeyStorage;
use trntv\bus\CommandBus;
use trntv\bus\middlewares\BackgroundCommandMiddleware;
use trntv\filekit\Storage;
use trntv\glide\components\Glide;
use yii\caching\DummyCache;
use yii\caching\FileCache;
use yii\db\Connection;
use yii\gii\Module;
use yii\helpers\ArrayHelper;
use yii\i18n\Formatter;
use yii\i18n\PhpMessageSource;
use yii\log\EmailTarget;
use yii\queue\file\Queue;
use yii\rbac\DbManager;
use yii\swiftmailer\Mailer;

$config = [
    'name' => 'Yii2 Starter Kit',
    'vendorPath' => __DIR__.'/../../vendor',
    'extensions' => require (__DIR__.'/../../vendor/yiisoft/extensions.php'),
    'sourceLanguage' => 'en-US',
    'language' => 'en-US',
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'authManager' => [
            'class' => DbManager::class,
            'itemTable' => '{{%rbac_auth_item}}',
            'itemChildTable' => '{{%rbac_auth_item_child}}',
            'assignmentTable' => '{{%rbac_auth_assignment}}',
            'ruleTable' => '{{%rbac_auth_rule}}',
        ],

        'cache' => [
            'class' => FileCache::class,
            'cachePath' => '@common/runtime/cache',
        ],

        'commandBus' => [
            'class' => CommandBus::class,
            'middlewares' => [
                [
                    'class' => BackgroundCommandMiddleware::class,
                    'backgroundHandlerPath' => '@console/yii',
                    'backgroundHandlerRoute' => 'command-bus/handle',
                ],
            ],
        ],

        'formatter' => [
            'class' => Formatter::class,
        ],

        'glide' => [
            'class' => Glide::class,
            'sourcePath' => '@storage/web/source',
            'cachePath' => '@storage/cache',
            'urlManager' => 'urlManagerStorage',
            'maxImageSize' => env('GLIDE_MAX_IMAGE_SIZE'),
            'signKey' => env('GLIDE_SIGN_KEY'),
        ],

        'mailer' => [
            'class' => Mailer::class,
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => env('ADMIN_EMAIL'),
            ],
        ],

        'db' => [
            'class' => Connection::class,
            'dsn' => env('DB_DSN'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'tablePrefix' => env('DB_TABLE_PREFIX'),
            'charset' => env('DB_CHARSET', 'utf8'),
            'enableSchemaCache' => YII_ENV_PROD,
        ],

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                'db' => [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['error', 'warning'],
                    'except' => ['yii\web\HttpException:*', 'yii\i18n\I18N\*'],
                    'prefix' => function () {
                        $url = !Yii::$app->request->isConsoleRequest ? Yii::$app->request->getUrl() : null;

                        return sprintf('[%s][%s]', Yii::$app->id, $url);
                    },
                    'logVars' => [],
                    'logTable' => '{{%system_log}}',
                ],
            ],
        ],

        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => PhpMessageSource::class,
                    'basePath' => '@common/messages',
                    'fileMap' => [
                        'common' => 'common.php',
                        'backend' => 'backend.php',
                        'frontend' => 'frontend.php',
                    ],
                    'on missingTranslation' => [backend\modules\translation\Module::class, 'missingTranslation'],
                ],
                /* Uncomment this code to use DbMessageSource
                '*'=> [
                    'class' => yii\i18n\DbMessageSource::class,
                    'sourceMessageTable'=>'{{%i18n_source_message}}',
                    'messageTable'=>'{{%i18n_message}}',
                    'enableCaching' => YII_ENV_DEV,
                    'cachingDuration' => 3600,
                    'on missingTranslation' => [backend\modules\translation\Module::class, 'missingTranslation']
                ],
                */
            ],
        ],

        'fileStorage' => [
            'class' => Storage::class,
            'baseUrl' => '@storageUrl/source',
            'filesystem' => [
                'class' => LocalFlysystemBuilder::class,
                'path' => '@storage/web/source',
            ],
            'as log' => [
                'class' => FileStorageLogBehavior::class,
                'component' => 'fileStorage',
            ],
        ],

        'keyStorage' => [
            'class' => KeyStorage::class,
        ],

        'urlManagerBackend' => ArrayHelper::merge(
            [
                'hostInfo' => env('BACKEND_HOST_INFO'),
                'baseUrl' => env('BACKEND_BASE_URL'),
            ],
            require (Yii::getAlias('@backend/config/_urlManager.php'))
        ),
        'urlManagerFrontend' => ArrayHelper::merge(
            [
                'hostInfo' => env('FRONTEND_HOST_INFO'),
                'baseUrl' => env('FRONTEND_BASE_URL'),
            ],
            require (Yii::getAlias('@frontend/config/_urlManager.php'))
        ),
        'urlManagerStorage' => ArrayHelper::merge(
            [
                'hostInfo' => env('STORAGE_HOST_INFO'),
                'baseUrl' => env('STORAGE_BASE_URL'),
            ],
            require (Yii::getAlias('@storage/config/_urlManager.php'))
        ),

        'queue' => [
            'class' => Queue::class,
            'path' => '@common/runtime/queue',
        ],
    ],
    'params' => [
        'adminEmail' => env('ADMIN_EMAIL'),
        'robotEmail' => env('ROBOT_EMAIL'),
        'availableLocales' => [
            'en-US' => 'English (US)',
            'ru-RU' => 'Русский (РФ)',
            'uk-UA' => 'Українська (Україна)',
            'es' => 'Español',
            'fr' => 'Français',
            'vi' => 'Tiếng Việt',
            'zh-CN' => '简体中文',
            'pl-PL' => 'Polski (PL)',
            'id-ID' => 'Indonesian (Bahasa)',
            'hu-HU' => 'Magyar',
        ],

        'metaTags' => [
            'meta_description' => [
                'name' => 'description',
                'content' => 'Your go-to source for affordable small business software solutions',
            ],
            'meta_keywords' => [
                'name' => 'keywords',
                'content' => 'daraspace, software, tutorial, information technology',
            ],
            'meta_author' => ['name' => 'author', 'content' => 'daraspace'],

            'og_site_name' => ['property' => 'og:site_name', 'content' => 'Daraspace'],
            'og_title' => ['property' => 'og:title', 'content' => 'Welcome to Daraspace'],
            'og_description' => [
                'property' => 'og:description',
                'content' => 'Discover beneficial content and resources.',
            ],
            'og_type' => ['property' => 'og:type', 'content' => 'website'],
            'og_url' => ['property' => 'og:url', 'content' => 'https://www.daraspace.com/'],
            'og_image' => [
                'property' => 'og:image',
                'itemprop' => 'image',
                'content' => 'https://www.daraspace.com/images/og-image.jpg',
            ],
            'og_width' => ['property' => 'og:image:width', 'content' => '200'],
            'og_height' => ['property' => 'og:image:height', 'content' => '100'],
            'og_updated_time' => ['property' => 'og:updated_time', 'content' => date('c', time())],

            'twitter_title' => ['name' => 'twitter:title', 'content' => 'Welcome to Daraspace'],
            'twitter_description' => [
                'name' => 'twitter:description',
                'content' => 'Discover beneficial content and resources.',
            ],
            'twitter_card' => ['name' => 'twitter:card', 'content' => 'summary_large_image'],
            'twitter_url' => ['name' => 'twitter:url', 'content' => 'https://www.daraspace.com/'],
            'twitter_image' => [
                'name' => 'twitter:image',
                'content' => 'https://www.daraspace.com/images/twitter-image.jpg',
            ],

            'googleplus_name' => ['itemprop' => 'name', 'content' => 'Welcome to Daraspace'],
            'googleplus_description' => [
                'itemprop' => 'description',
                'content' => 'Discover beneficial content and resources.',
            ],
            'googleplus_image' => [
                'itemprop' => 'image',
                'content' => 'https://www.daraspace.com/images/googleplus-image.jpg',
            ],
        ],

        'bsVersion' => '4.x', // bootstrap version
    ],
];

if (YII_ENV_PROD) {
    $config['components']['log']['targets']['email'] = [
        'class' => EmailTarget::class,
        'except' => ['yii\web\HttpException:*'],
        'levels' => ['error', 'warning'],
        'message' => ['from' => env('ROBOT_EMAIL'), 'to' => env('ADMIN_EMAIL')],
    ];
}

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => Module::class,
    ];

    $config['components']['cache'] = [
        'class' => DummyCache::class,
    ];
    $config['components']['mailer']['transport'] = [
        'class' => 'Swift_SmtpTransport',
        'host' => env('SMTP_HOST'),
        'port' => env('SMTP_PORT'),
    ];
}

return $config;
