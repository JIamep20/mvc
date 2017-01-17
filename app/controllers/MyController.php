<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16.10.2016
 * Time: 2:06
 */

namespace App\Controllers;
use Framework\Controller;


/**
 * Class Controller
 * @package App\Controllers
 */
class MyController extends Controller
{
    /**
     * Checks if user is authorized
     * @return bool
     */
    protected function is_authorized()
    {
        return array_key_exists('login', $_SESSION);
    }

    /**
     * Adds to the request condition
     * @param $query
     * @param $str
     * @param string $condition
     * @return string
     */
    protected function prepare_condition($query, $str, $condition = 'and')
    {
        if(strpos($query, 'where') || strpos($query, 'WHERE')) {
            $query .= ' ' . $condition . ' ' . $str;
        } else {
            $query .= ' where ' . $str;
        }

        return $query;
    }
}