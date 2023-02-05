<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class LawyerAsset extends AssetBundle {

    public $basePath = '@webroot/themes/lawyer';
    public $baseUrl = '@web/themes/lawyer';
    
    public $css = [
        'https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700',
        
        //CSS Global Compulsory
        'vendor/bootstrap/bootstrap.min.css',
        'vendor/icon-line/css/simple-line-icons.css',
        'vendor/icon-awesome/css/font-awesome.min.css',
        'vendor/icon-hs/style.css',
        
        //CSS Implementing Plugins
        'vendor/hamburgers/hamburgers.min.css',
        'vendor/slick-carousel/slick/slick.css',
        
        //Revolution Slider
        'vendor/revolution-slider/revolution/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css',
        'vendor/revolution-slider/revolution/css/settings.css',
        'vendor/revolution-slider/revolution/css/layers.css',
        'vendor/revolution-slider/revolution/css/navigation.css',
        
        //CSS Template
        'css/styles.op-lawyer.css',
        
        //CSS Customization
        //NOT EXIST
        //'css/custom.css'
    ];
    
    public $js = [
        
        //JS Global Compulsory
        'vendor/jquery/jquery.min.js',
        'vendor/jquery-migrate/jquery-migrate.min.js',
        'vendor/popper.js/popper.min.js',
        'vendor/bootstrap/bootstrap.min.js',
        
        //JS Implementing Plugins
        'vendor/appear.js',
        'vendor/slick-carousel/slick/slick.js',
        'vendor/gmaps/gmaps.min.js',
        
        //JS Revolution Slider
        'vendor/revolution-slider/revolution/js/jquery.themepunch.tools.min.js',
        'vendor/revolution-slider/revolution/js/jquery.themepunch.revolution.min.js',
        'vendor/revolution-slider/revolution-addons/slicey/js/revolution.addon.slicey.min.js',
        'vendor/revolution-slider/revolution/js/extensions/revolution.extension.actions.min.js',
        'vendor/revolution-slider/revolution/js/extensions/revolution.extension.carousel.min.js',
        'vendor/revolution-slider/revolution/js/extensions/revolution.extension.kenburn.min.js',
        'vendor/revolution-slider/revolution/js/extensions/revolution.extension.layeranimation.min.js',
        'vendor/revolution-slider/revolution/js/extensions/revolution.extension.migration.min.js',
        'vendor/revolution-slider/revolution/js/extensions/revolution.extension.parallax.min.js',
        'vendor/revolution-slider/revolution/js/extensions/revolution.extension.slideanims.min.js',

        //JS Unify
        'js/hs.core.js',
        'js/components/hs.header.js',
        'js/helpers/hs.hamburgers.js',
        'js/components/hs.scroll-nav.js',
        'js/components/hs.carousel.js',
        'js/components/gmap/hs.map.js',
        'js/components/hs.go-to.js',
    
        //JS Customization
        'js/custom.js'
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];

}
