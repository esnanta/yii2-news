<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components/Ionicons'; 
    
    public $css = [
        'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic',
        'css/ionicons.min.css',  
//        'dist/css/skins/_all-skins.min.css',
//        'bower_components/morris.js/morris.css',
//        'bower_components/jvectormap/jquery-jvectormap.css',
//        'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',        
    ];
    public $js = [
//        'bower_components/raphael/raphael.min.js',
//        'bower_components/morris.js/morris.min.js',
//        'bower_components/jquery-sparkline/dist/jquery.sparkline.min.js',
//        'plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
//        'plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
//        'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
//        'bower_components/jquery-slimscroll/jquery.slimscroll.min.js',
//        'bower_components/fastclick/lib/fastclick.js',        
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
