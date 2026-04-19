<?php

namespace frontend\assets;

use common\assets\Html5shiv;
use rmrevin\yii\fontawesome\NpmFreeAssetBundle;
use yii\bootstrap4\BootstrapAsset;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

/**
 * Main frontend application asset bundle.
 */
class Bootstrap4news extends AssetBundle
{
    public $basePath = '@webroot/themes/bootstrap4news/assets';
    public $baseUrl = '@web/themes/bootstrap4news/assets';

    public $css = [
        'https://fonts.googleapis.com/css?family=Montserrat:400,600&display=swap',
        'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css',
        'vendor/fontawesome-free/css/all.min.css',
        'lib/slick/slick.css',
        'lib/slick/slick-theme.css',
        'css/style.css',
    ];

    public $js = [
        'https://code.jquery.com/jquery-3.4.1.min.js',
        'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js',
        'lib/easing/easing.min.js',
        'lib/slick/slick.min.js',
        'js/main.js',
    ];
    public $depends = [
        YiiAsset::class,
        BootstrapAsset::class,
        Html5shiv::class,
        NpmFreeAssetBundle::class,
    ];
}
