<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class Portfolio7Asset extends AssetBundle {

    public $basePath = '@webroot/themes/portfolio7';
    public $baseUrl = '@web/themes/portfolio7';
    
    public $css = [
        'https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700',
        'vendor/bootstrap/bootstrap.min.css',
        'vendor/icon-awesome/css/font-awesome.min.css',
        'vendor/icon-line/css/simple-line-icons.css',
        'vendor/icon-etlinefont/style.css',
        'vendor/icon-line-pro/style.css',
        'vendor/icon-hs/style.css',
        'vendor/animate.css',
        'vendor/fancybox/jquery.fancybox.css',
        'vendor/cubeportfolio-full/cubeportfolio/css/cubeportfolio.min.css',
        'vendor/hs-megamenu/src/hs.megamenu.css',
        'vendor/hamburgers/hamburgers.min.css',
        'css/unify-core.css',
        'css/unify-globals.css',
        'css/custom.css',
    ];
    
    public $js = [

        'vendor/jquery/jquery.min.js',
        'vendor/jquery-migrate/jquery-migrate.min.js',
        'vendor/jquery.easing/js/jquery.easing.js',
        'vendor/popper.js/popper.min.js',
        'vendor/bootstrap/bootstrap.min.js',
        
        'vendor/hs-megamenu/src/hs.megamenu.js',
        'vendor/fancybox/jquery.fancybox.min.js', 
        'vendor/cubeportfolio-full/cubeportfolio/js/jquery.cubeportfolio.min.js',
        'js/hs.core.js',
        'js/components/hs.header.js',
        'js/helpers/hs.hamburgers.js',
        'js/components/hs.tabs.js',
        'js/components/hs.cubeportfolio.js',
        'js/components/hs.go-to.js',
        'js/custom.js',
    ];
    
    public $depends = [
        //'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];

}
