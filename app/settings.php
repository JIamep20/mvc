<?php

/**
 * Settings for DB connection,
 * app debugging,
 * twig caching
 */
return [
    'db_server' => 'localhost',
    'db_name' => 'new_project',
    'db_user' => 'root',
    'db_password' => '123456',

    'debug' => false,
    'twig' => [
        'cache' => false
    ]
];