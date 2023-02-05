<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class CollegeAsset extends AssetBundle
{
    public $basePath = '@webroot/themes/college';
    public $baseUrl = '@web/themes/college';

    public $css = [

        'https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700',

        //rujukan : https://demos.krajee.com/widget-details/fileinput#override-bootstrap-cssjs
        //'https://use.fontawesome.com/releases/v5.3.1/css/all.css',

        'plugins/bootstrap/css/bootstrap.min.css',
        'plugins/font-awesome/css/font-awesome.css',
        'plugins/flexslider/flexslider.css',
        'plugins/Gallery/css/blueimp-gallery.min.css',

        //'blog/css/blog-card.css',
        'blog/css/article-thumbnails.css',

        'css/styles.css',

        //CHANGE TO LAYOUT
    ];

    public $js = [

        //rujukan : https://demos.krajee.com/widget-details/fileinput#override-bootstrap-cssjs
        //'https://use.fontawesome.com/releases/v5.3.1/js/all.js',

        //BENTROK SAMA DROPDOWN
        //'plugins/jquery-3.2.1.min.js',

        'plugins/popper.min.js',
        
        //KALAU AKTIF, MASALAH DI DROPDOWN
        //KALAU NON AKTIF, MASALAH DI MENU DROPDOWN
        'plugins/bootstrap/js/bootstrap.min.js',
        
        'plugins/back-to-top.js',
        'plugins/flexslider/jquery.flexslider-min.js',
        'plugins/jflickrfeed/jflickrfeed.min.js',
        'plugins/Gallery/js/jquery.blueimp-gallery.min.js',

        'js/main.js',
        'js/gallery.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
