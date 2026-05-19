<?php

use yii\helpers\ArrayHelper;
use yii\web\Application;

// ex:
// /public_html/news/storage/web
$root = dirname(__DIR__, 4);

// Repository app.
$app = $root.'/repositories/yii2-news';

// Composer.
require $app.'/vendor/autoload.php';

// Environment.
require $app.'/common/env.php';

// Yii framework.
require $app.'/vendor/yiisoft/yii2/Yii.php';

// Bootstrap.
require $app.'/common/config/bootstrap.php';

// Merge config:
// - original repository config
// - hosting/public_html override
$config = ArrayHelper::merge(
    require $app.'/storage/config/base.php',
    require dirname(__DIR__).'/config/web.php'
);

// Run app.
(new Application($config))->run();
