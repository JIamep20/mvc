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
class BaseController
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
        $this->pdo = DB::instance();
        if(method_exists($this, $method)) {
            $this->{$method}($params, $request);
        } else {
            throw new \Exception('Method \'' .$method . '\' in controller ' . static::class . ' does not exist.');
        }
    }
}