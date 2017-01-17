<?php

use \Framework\Router;

/**
 * Define here routes for your app
 * Callback function retrieve $args as route params
 */

Router::get('aaa', function (){
    return \App\Models\City::all();
});


Router::get('login/{asd}/{dfg}', 'AuthController@show_login_form');
Router::post('login', 'AuthController@login');
Router::get('logout', 'AuthController@logout');

/*Router::get('register', 'AuthController@show_register_form');
Router::post('register', 'AuthController@register');

Router::get('admin', 'AdressBook@adminIndex', 'Auth');
Router::get('', 'AdressBook@guestIndex');*/