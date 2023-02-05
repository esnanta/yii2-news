<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class Unify196 extends AssetBundle
{
    public $basePath = '@webroot/themes/unify196';
    public $baseUrl = '@web/themes/unify196';
    

    public $css = [
        
        'https://fonts.googleapis.com/css?family=Open+Sans:400,300,600&amp;subset=cyrillic,latin',
        
        //CSS Global Compulsory
        'plugins/bootstrap/css/bootstrap.min.css',
        'css/style.css',

	//CSS Header and Footer 
        'css/headers/header-default.css',
        'css/footers/footer-v1.css',

	// CSS Implementing Plugins
        'plugins/animate.css',
        'plugins/line-icons/line-icons.css',
        'plugins/font-awesome/css/font-awesome.min.css',
        'plugins/fancybox/source/jquery.fancybox.css',
        'plugins/parallax-slider/css/parallax-slider.css',
        'plugins/owl-carousel/owl-carousel/owl.carousel.css',

        'plugins/cube-portfolio/cubeportfolio/css/cubeportfolio.min.css',
        'plugins/cube-portfolio/cubeportfolio/custom/custom-cubeportfolio.css',      
        
	//CSS Page Style
        'css/pages/blog.css',
        'css/pages/page_pricing.css',
        'css/pages/page_404_error.css',
        'css/pages/profile.css',
        'css/pages/page_invoice.css',

	// CSS Theme 
        'css/theme-colors/default.css',
        'css/theme-skins/dark.css',

	// CSS Customization 
        'css/custom.css',

    ];
    


    public $js = [
        // JS Global Compulsory
        //'plugins/jquery/jquery.min.js', OTHERWISE FORM NOT FUNCTION PROPERLY
        'plugins/jquery/jquery-migrate.min.js',
        'plugins/bootstrap/js/bootstrap.min.js',

	// JS Implementing Plugins -->
        'plugins/back-to-top.js',
        'plugins/smoothScroll.js',
        'plugins/jquery.parallax.js',
        'plugins/fancybox/source/jquery.fancybox.pack.js',
        'plugins/parallax-slider/js/modernizr.js',
        'plugins/parallax-slider/js/jquery.cslider.js',
        'plugins/owl-carousel/owl-carousel/owl.carousel.js',
        'plugins/cube-portfolio/cubeportfolio/js/jquery.cubeportfolio.min.js',
        
//        'plugins/sky-forms-pro/skyforms/js/jquery.validate.min.js',
//        'plugins/sky-forms-pro/skyforms/js/jquery.maskedinput.min.js',
//        'plugins/sky-forms-pro/skyforms/js/jquery-ui.min.js',
//        'plugins/sky-forms-pro/skyforms/js/jquery.form.min.js',
                
	// JS Page Level -->
        'js/app.js',
        'js/plugins/cube-portfolio/cube-portfolio-4.js',
        'js/plugins/fancy-box.js',
        'js/plugins/owl-carousel.js',
        'js/plugins/style-switcher.js',
        'js/plugins/parallax-slider.js',

	// JS Customization
        'js/custom.js',        
        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
