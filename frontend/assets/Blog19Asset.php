<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class Blog19Asset extends AssetBundle
{
    public $basePath = '@webroot/themes/blog19';
    public $baseUrl = '@web/themes/blog19';

    public $css = [

        'https://fonts.googleapis.com/css?family=Roboto+Slab:400,300,700',

        //CSS Global Compulsory
        'plugins/bootstrap/css/bootstrap.min.css',
        //'css/style.css',
        'css/blog.style.css',

        //CSS Header and Footer
        'css/headers/header-v8.css',
        'css/footers/footer-v8.css',

        //CSS Implementing Plugins
        'plugins/animate.css',
        'plugins/line-icons/line-icons.css',
        'plugins/fancybox/source/jquery.fancybox.css',
        'plugins/font-awesome/css/font-awesome.min.css',
        'plugins/master-slider/masterslider/style/masterslider.css',
        'plugins/master-slider/masterslider/skins/black-2/style.css',
        'plugins/login-signup-modal-window/css/style.css',
        'plugins/sky-forms-pro/skyforms/css/sky-forms.css',
        'plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css',

        'plugins/cube-portfolio/cubeportfolio/css/cubeportfolio.min.css',
        'plugins/cube-portfolio/cubeportfolio/custom/custom-cubeportfolio.css',

        //CSS Page Style
        'css/pages/profile.css',
        'css/pages/page_contact.css',
        'css/pages/shortcode_timeline1.css',

        //CSS Theme
        'css/theme-colors/default.css',
        'css/theme-skins/dark.css',

        //CSS Customization
        'css/custom.css'
    ];



    public $js = [
        // JS Global Compulsory

        'plugins/jquery/jquery.min.js',
        'plugins/jquery/jquery-migrate.min.js',
        'plugins/bootstrap/js/bootstrap.min.js',

        // JS Implementing Plugins
        'plugins/back-to-top.js',
        'plugins/smoothScroll.js',
        'plugins/counter/waypoints.min.js',
        'plugins/counter/jquery.counterup.min.js',
        'plugins/master-slider/masterslider/masterslider.js',
        'plugins/master-slider/masterslider/jquery.easing.min.js',

        'plugins/masonry/masonry.pkgd.min.js',
        'plugins/masonry/imagesloaded.pkgd.min.js',

        'plugins/modernizr.js',
        'plugins/login-signup-modal-window/js/main.js',

        // JS Page Level
        'js/app.js',
        'js/plugins/fancy-box.js',
        'js/plugins/owl-carousel.js',
        'js/plugins/master-slider-showcase4.js',
        'js/plugins/style-switcher.js',
        'js/plugins/blog-masonry.js',

        'js/custom.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
}
