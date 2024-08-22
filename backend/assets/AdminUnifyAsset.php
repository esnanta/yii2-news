<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AdminUnifyAsset extends AssetBundle
{
    public $basePath = '@webroot/themes-admin-unify';
    public $baseUrl = '@web/themes-admin-unify';
    public $css = [

        "https://use.fontawesome.com/releases/v5.3.1/css/all.css",

        //CSS Global Compulsory
        //'assets-main/vendor/bootstrap/bootstrap.min.css',

        //CSS Global Icons
        'assets-main/vendor/icon-awesome/css/font-awesome.min.css',
        'assets-main/vendor/icon-line/css/simple-line-icons.css',
        'assets-main/vendor/icon-etlinefont/style.css',
        'assets-main/vendor/icon-line-pro/style.css',
        'assets-main/vendor/icon-hs/style.css',

        'assets/vendor/hs-admin-icons/hs-admin-icons.css',

        'assets-main/vendor/animate.css',
        'assets-main/vendor/malihu-scrollbar/jquery.mCustomScrollbar.min.css',

        'assets/vendor/flatpickr/dist/css/flatpickr.min.css',
        'assets/vendor/bootstrap-select/css/bootstrap-select.min.css',
        'assets/vendor/chartist-js/chartist.min.css',
        'assets/vendor/chartist-js-tooltip/chartist-plugin-tooltip.css',

        'assets-main/vendor/fancybox/jquery.fancybox.min.css',
        'assets-main/vendor/hamburgers/hamburgers.min.css',

        //CSS Unify
        'assets/css/unify-admin.css',
        'assets/css/custom.css'

    ];

    public $js = [
        //Global Compulsory
        //'assets/vendor/jquery/jquery.min.js', //DISABLE SUPAYA BISA KARTIK SELECT2
        'assets/vendor/jquery-migrate/jquery-migrate.min.js',

        'assets-main/vendor/popper.js/popper.min.js',
        'assets-main/vendor/bootstrap/bootstrap.min.js',
        'assets-main/vendor/cookiejs/jquery.cookie.js',

        //jQuery UI Core
        'assets-main/vendor/jquery-ui/ui/widget.js',
        'assets-main/vendor/jquery-ui/ui/version.js',
        'assets-main/vendor/jquery-ui/ui/keycode.js',
        'assets-main/vendor/jquery-ui/ui/position.js',
        'assets-main/vendor/jquery-ui/ui/unique-id.js',
        'assets-main/vendor/jquery-ui/ui/safe-active-element.js',

        //jQuery UI Helpers
        'assets-main/vendor/jquery-ui/ui/widgets/menu.js',
        'assets-main/vendor/jquery-ui/ui/widgets/mouse.js',

        //jQuery UI Widgets
        'assets-main/vendor/jquery-ui/ui/widgets/datepicker.js',

        //JS Plugins Init
        'assets-main/vendor/appear.js',
        'assets/vendor/bootstrap-select/js/bootstrap-select.min.js',
        'assets/vendor/flatpickr/dist/js/flatpickr.min.js',

        'assets-main/vendor/malihu-scrollbar/jquery.mCustomScrollbar.concat.min.js',

        'assets/vendor/chartist-js/chartist.min.js',
        'assets/vendor/chartist-js-tooltip/chartist-plugin-tooltip.js',
        'assets/vendor/fancybox/jquery.fancybox.min.js',

        //JS Unify
        'assets-main/js/hs.core.js',

        'assets/js/components/hs.side-nav.js',

        'assets-main/js/helpers/hs.hamburgers.js',

        'assets/js/components/hs.range-datepicker.js',

        'assets-main/js/components/hs.datepicker.js',
        'assets-main/js/components/hs.dropdown.js',
        'assets-main/js/components/hs.scrollbar.js',

        'assets/js/components/hs.area-chart.js',
        'assets/js/components/hs.donut-chart.js',
        'assets/js/components/hs.bar-chart.js',

        'assets-main/js/helpers/hs.focus-state.js',

        'assets/js/components/hs.popup.js',

        //JS Custom
        'assets-main/js/custom.js'

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
