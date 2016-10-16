<?php

/**
 * App Access Point / Front Controller
 */

require('../vendor/autoload.php');

define('SETTINGS', require('../app/settings.php'));
define('BASE_DIR', __DIR__ . '/../');
define('FRAMEWORK_DIR', __DIR__ . '/../framework');
define('CACHE_DIR', __DIR__ . '/../framework/cache');
define('TEMPLATES_DIR', __DIR__ . '/../app/views');

new \Framework\Kernel();

