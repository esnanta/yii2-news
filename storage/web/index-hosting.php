<?php

// This entry point is intended for public_html deployments.

use yii\web\Application;

// Project root resolved for this hosting setup.
// ex. public_html/news/storage/web -> 4
$root = dirname(__DIR__, 4);

// Application source directory.
$app = $root.'/repositories/yii2-news';

// Load the Composer autoloader.
require $app.'/vendor/autoload.php';

// Load environment variables from .env.
require $app.'/common/env.php';

// Load the Yii framework core.
require $app.'/vendor/yiisoft/yii2/Yii.php';

// Run application bootstrap files.
require $app.'/common/config/bootstrap.php';

// Load storage application config.
$config = require $app.'/storage/config/base.php';

// Start the application.
(new Application($config))->run();
