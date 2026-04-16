<?php

use common\behaviors\LocaleBehavior;
use yii\debug\Module;
use yii\web\AssetManager;
use yii\widgets\LinkPager;

$config = [
    'components' => [
        'assetManager' => [
            'class' => AssetManager::class,
            'linkAssets' => env('LINK_ASSETS'),
            'appendTimestamp' => YII_ENV_DEV,
        ],
    ],
    'as locale' => [
        'class' => LocaleBehavior::class,
        'enablePreferredLanguage' => true,
    ],
    'container' => [
        'definitions' => [
            LinkPager::class => yii\bootstrap4\LinkPager::class,
        ],
    ],
];

if (YII_DEBUG) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => Module::class,
        'allowedIPs' => ['*'],
    ];
}

if (YII_ENV_DEV) {
    $config['modules']['gii'] = [
        'allowedIPs' => ['*'],
    ];
}

return $config;
