<?php

use \Framework\Router;

/**
 * Define here routes for your app
 * Callback function retrieve $args as route params
 */

Router::get('', function($args) {dump($args, true);});