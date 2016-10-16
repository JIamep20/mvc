<?php

use \Framework\Router;

/**
 * Define here routes for your app
 * Callback function retrieve $args as route params
 */

Router::get('', function($args) {});
Router::get('/1/{1}/{2}/3/{4}', function($args) {});
Router::get('/2/{vote}/{asd2}/3/{zxc4}/2/{vbn5}', function($args) {render('app', ['data' => $args]);});