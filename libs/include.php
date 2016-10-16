<?php

/**
 * This file is required to autoload.php by composer and requires libs/modules.
 */

$files = glob(__DIR__ . '/modules/*.*');
if ($files === false) {
    throw new RuntimeException("Failed to glob for function files");
}
foreach ($files as $file) {
    require_once $file;
}
unset($file);
unset($files);