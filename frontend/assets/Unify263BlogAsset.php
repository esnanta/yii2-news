<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class Unify263BlogAsset extends AssetBundle
{
    public $basePath = '@webroot/themes/unify263blog/assets';
    public $baseUrl = '@web/themes/unify263blog/assets';
    

    public $css = [
        
        'https://fonts.googleapis.com/css?family=Roboto+Slab:300,400,700%7COpen+Sans:400,600,700',
        'https://use.fontawesome.com/releases/v5.3.1/css/all.css',
        //CSS Global Compulsory
        'vendor/bootstrap/bootstrap.min.css',
        
        //CSS Implementing Plugins
        'vendor/icon-awesome/css/font-awesome.min.css',
        'vendor/icon-line/css/simple-line-icons.css',
        'vendor/icon-line-pro/style.css',
        'vendor/icon-hs/style.css',
        'vendor/dzsparallaxer/dzsparallaxer.css',
        'vendor/dzsparallaxer/dzsscroller/scroller.css',
        'vendor/dzsparallaxer/advancedscroller/plugin.css',
        'vendor/animate.css',
        'vendor/malihu-scrollbar/jquery.mCustomScrollbar.min.css',
        'vendor/hs-megamenu/src/hs.megamenu.css',
        'vendor/hamburgers/hamburgers.min.css',
        'vendor/slick-carousel/slick/slick.css',
        'vendor/fancybox/jquery.fancybox.css',
        
        //CSS Unify
        'css/unify-core.css',
        'css/unify-components.css',
        'css/unify-globals.css',
        
        //CSS Unify Theme
        'css/styles.bm-classic.css',
        
        //CSS Customization
        'css/custom.css',

    ];
    
    
    
    public $js = [
        //JS Global Compulsory
        'vendor/jquery/jquery.min.js',
        'vendor/jquery-migrate/jquery-migrate.min.js',
        'vendor/popper.js/popper.min.js',
        'vendor/bootstrap/bootstrap.min.js',
        
        //JS Implementing Plugins
        'vendor/appear.js',
        'vendor/dzsparallaxer/dzsparallaxer.js',
        'vendor/dzsparallaxer/dzsscroller/scroller.js',
        'vendor/dzsparallaxer/advancedscroller/plugin.js',
        'vendor/hs-megamenu/src/hs.megamenu.js',
        'vendor/slick-carousel/slick/slick.js',
        'vendor/fancybox/jquery.fancybox.min.js',
        'vendor/malihu-scrollbar/jquery.mCustomScrollbar.concat.min.js',
        
        //JS Unify
        'js/hs.core.js',
        'js/components/hs.header.js',
        'js/helpers/hs.hamburgers.js',
        'js/components/hs.dropdown.js',
        'js/components/hs.counter.js',
        'js/components/hs.onscroll-animation.js',
        'js/components/hs.sticky-block.js',
        'js/components/hs.carousel.js',
        'js/components/hs.popup.js',
        'js/components/hs.go-to.js',
        'js/components/hs.scrollbar.js',
        
        //JS Customization
        'js/custom.js'
            
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
