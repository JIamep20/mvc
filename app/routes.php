<?php

use \Framework\Router;

/**
 * Define here routes for your app
 * Callback function retrieve $args as route params
 */

#TODO numeric params
Router::get('', function($args) {
    dump($args);
});
Router::get('/1/{page1}/{xcv}/3/{4}', function($args) {dump($args);});
Router::get('/2/{vote}/{asd2}/3/{zxc4}/2/{vbn5}', function($args) {dump($args);});