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

    'modules' => [
        // http://demos.krajee.com/social#installation
        'social' => [
            // the module class
            'class' => 'kartik\social\Module',
            // the global settings for the Disqus widget
            'disqus' => [
                'settings' => ['shortname' => 'warta-smanmba-1'], // default settings
            ],
            // the global settings for the Facebook plugins widget
            'facebook' => [
                'appId' => 'FACEBOOK_APP_ID',
                'secret' => 'FACEBOOK_APP_SECRET',
            ],
            // the global settings for the Google+ Plugins widget
            'google' => [
                'clientId' => 'GOOGLE_API_CLIENT_ID',
                'pageId' => 'GOOGLE_PLUS_PAGE_ID', // GOOGLE_PLUS_PAGE_ID
                'profileId' => 'GOOGLE_PLUS_PROFILE_ID', // GOOGLE_PLUS_PROFILE_ID
            ],
            // the global settings for the Google Analytics plugin widget
            'googleAnalytics' => [
                'id' => 'TRACKING_ID',
                'domain' => 'TRACKING_DOMAIN',
            ],
            // the global settings for the Twitter plugin widget
            'twitter' => [
                'screenName' => 'TWITTER_SCREEN_NAME',
            ],
            // the global settings for the GitHub plugin widget
            'github' => [
                'settings' => ['user' => 'GITHUB_USER', 'repo' => 'GITHUB_REPO'],
            ],
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
