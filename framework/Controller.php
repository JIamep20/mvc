<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16.10.2016
 * Time: 2:22
 */

namespace Framework;

/**
 * Class BaseController
 * Base class for App controllers
 * @package Framework
 */
abstract class Controller
{

    protected $pdo;
    
    /**
     * BaseController constructor.
     * @param $method
     * @param array $args
     * @param array $middleware
     */
    public function __construct($method, $params = [], $request = [])
    {
        if(method_exists($this, $method)) {
            if($res = $this->{$method}($params, $request)){
                echo '<pre style="word-wrap: break-word; white-space: pre-wrap;">' . json_encode($res) . '</pre>';
            }
        } else {
            throw new \Exception('Method \'' .$method . '\' in controller ' . static::class . ' does not exist.');
        }
    }
}