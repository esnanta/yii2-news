<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class NiceAdminAsset extends AssetBundle
{
    public $basePath = '@webroot/themes-niceadmin';
    public $baseUrl = '@web/themes-niceadmin';

    public $css = [
        'https://use.fontawesome.com/releases/v5.3.1/css/all.css',
        'https://fonts.gstatic.com',
        'https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i',

        //Vendor CSS Files
        'assets/vendor/bootstrap/css/bootstrap.min.css',
        'assets/vendor/bootstrap-icons/bootstrap-icons.css',
        'assets/vendor/boxicons/css/boxicons.min.css',
        'assets/vendor/quill/quill.snow.css',
        'assets/vendor/quill/quill.bubble.css',
        'assets/vendor/remixicon/remixicon.css',
        'assets/vendor/simple-datatables/style.css',

        //Template Main CSS File
        'assets/css/style.css'
    ];
    public $js = [
        //Vendor JS Files
        'assets/vendor/apexcharts/apexcharts.min.js',
        'assets/vendor/bootstrap/js/bootstrap.bundle.min.js',
        'assets/vendor/chart.js/chart.umd.js',
        'assets/vendor/echarts/echarts.min.js',
        'assets/vendor/quill/quill.js',
        'assets/vendor/simple-datatables/simple-datatables.js',
        'assets/vendor/tinymce/tinymce.min.js',
        'assets/vendor/php-email-form/validate.js',

        //Template Main JS File
        'assets/js/main.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
