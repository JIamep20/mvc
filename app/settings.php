<?php

/**
 * Settings for DB connection,
 * app debugging,
 * twig caching
 */
return [
    'db_host' => 'localhost',
    'db_name' => 'mydb',
    'db_user' => 'root',
    'db_password' => '123456',

    'debug' => true,
    'twig' => [
        'cache' => false
    ]
];