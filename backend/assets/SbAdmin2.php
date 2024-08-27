<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class SbAdmin2 extends AssetBundle
{
    public $basePath = '@webroot/themes-sbadmin2';
    public $baseUrl = '@web/themes-sbadmin2';
    public $css = [
        // Custom fonts for this template-->
        'assets/vendor/fontawesome-free/css/all.min.css',
        'https://use.fontawesome.com/releases/v5.3.1/css/all.css',
        'https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i',
        // Custom styles for this template-->
        'assets/css/sb-admin-2.min.css',
    ];
    public $js = [
        // Bootstrap core JavaScript-->
        //'assets/vendor/jquery/jquery.min.js',
        'assets/vendor/bootstrap/js/bootstrap.bundle.min.js',

        // Core plugin JavaScript-->
        //'assets/vendor/jquery-easing/jquery.easing.min.js',

        // Custom scripts for all pages-->
        'assets/js/sb-admin-2.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
