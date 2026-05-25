<?php

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

$config = require $app.'/storage/config/base.php';

// Run app.
(new Application($config))->run();
