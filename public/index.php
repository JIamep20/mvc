<?php

/**
 * App Access Point / Front Controller
 */
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require('../vendor/autoload.php');

define('SETTINGS', require('../app/settings.php'));
define('BASE_DIR', __DIR__ . '/../');
define('FRAMEWORK_DIR', __DIR__ . '/../framework');
define('CACHE_DIR', __DIR__ . '/../framework/cache');
define('TEMPLATES_DIR', __DIR__ . '/../app/views');

session_start();

$app = new \Framework\Kernel();

