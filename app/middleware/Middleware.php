<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16.10.2016
 * Time: 17:36
 */

namespace App\Middleware;


use Framework\BaseMiddleware;

/**
 * Class Middleware
 * @package App\Middleware
 */
class Middleware extends BaseMiddleware
{
    /**
     * Checks if user is authorized
     * @return bool
     */
    protected function is_authorized()
    {
        return array_key_exists('login', $_SESSION);
    }
}