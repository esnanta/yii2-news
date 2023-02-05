<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class Home14Asset extends AssetBundle
{
    public $basePath = '@webroot/themes/home14';
    public $baseUrl = '@web/themes/home14';
    

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
        'vendor/hs-megamenu/src/hs.megamenu.css',
        'vendor/hamburgers/hamburgers.min.css',
        
        'vendor/slick-carousel/slick/slick.css',
        'vendor/typedjs/typed.css',
 
        'vendor/cubeportfolio-full/cubeportfolio/css/cubeportfolio.min.css',
        
        'vendor/revolution-slider/revolution/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css',
        'vendor/revolution-slider/revolution/css/settings.css',
        'vendor/revolution-slider/revolution/css/layers.css',
        'vendor/revolution-slider/revolution/css/navigation.css',
        
        'css/unify-core.css',
        'css/unify-components.css',
        'css/unify-globals.css',
        
        'css/custom.css',
    ];
    
    
    
    public $js = [
        'vendor/jquery/jquery.min.js',
        'vendor/jquery-migrate/jquery-migrate.min.js',
        'vendor/jquery.easing/js/jquery.easing.js',
        'vendor/popper.js/popper.min.js',
        'vendor/bootstrap/bootstrap.min.js',
        
        'vendor/appear.js',
        'vendor/hs-megamenu/src/hs.megamenu.js',
        'vendor/fancybox/jquery.fancybox.min.js',
        
        'vendor/slick-carousel/slick/slick.js',
        'vendor/typedjs/typed.min.js',
      
        'vendor/cubeportfolio-full/cubeportfolio/js/jquery.cubeportfolio.min.js',
        
        'vendor/gmaps/gmaps.min.js',

        'vendor/revolution-slider/revolution/js/jquery.themepunch.tools.min.js',
        'vendor/revolution-slider/revolution/js/jquery.themepunch.revolution.min.js',
        'vendor/revolution-slider/revolution-addons/slicey/js/revolution.addon.slicey.min.js',
        'vendor/revolution-slider/revolution/js/extensions/revolution.extension.actions.min.js',
        'vendor/revolution-slider/revolution/js/extensions/revolution.extension.carousel.min.js',
        'vendor/revolution-slider/revolution/js/extensions/revolution.extension.kenburn.min.js',
        'vendor/revolution-slider/revolution/js/extensions/revolution.extension.layeranimation.min.js',
        'vendor/revolution-slider/revolution/js/extensions/revolution.extension.migration.min.js',
        'vendor/revolution-slider/revolution/js/extensions/revolution.extension.navigation.min.js',
        'vendor/revolution-slider/revolution/js/extensions/revolution.extension.parallax.min.js',
        'vendor/revolution-slider/revolution/js/extensions/revolution.extension.slideanims.min.js',
        'vendor/revolution-slider/revolution/js/extensions/revolution.extension.video.min.js',

        'js/hs.core.js',
        'js/components/hs.header.js',
        'js/helpers/hs.hamburgers.js',
        'js/components/hs.tabs.js',
        'js/components/hs.cubeportfolio.js',
        'js/components/hs.popup.js',
        'js/components/hs.onscroll-animation.js',
        
        'js/components/hs.sticky-block.js',
        'js/components/hs.go-to.js',
        'js/components/hs.carousel.js',
        'js/components/text-animation/hs.text-slideshow.js',

        'js/custom.js',
            
    
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
