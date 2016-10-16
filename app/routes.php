<?php

// Split middleware using '.'
// Callbacks get $args in params
// Use 'closure' => function($args) {render('....');};

return [
    //example
    ['r' => 'example', 'type' => 'get', 'middleware' => 'Middleware', 'controller' => 'Controller', 'method' => 'index', 'callback' => function($args) {render('app');}],

];