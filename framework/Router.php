<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16.10.2016
 * Time: 19:18
 */

namespace Framework;


use App\Exceptions\Exception;

/**
 * Class Router provides convenient routes defining
 * @package Framework
 */
class Router
{
    protected static $routes = [];

    /**
     * @param $type
     * @param $route
     * @param $method
     * @param null $middleware
     * @throws Exception
     */
    public static function add($type, $route, $method, $middleware = null)
    {
        $r = [];
        $r['type'] = $type;
        $r['r'] = $route;

        if(is_callable($method)) {
            $r['method'] = $method;
        } elseif(is_string($method)) {
            if(count($temp = explode('@', $method)) == 2) {
                $r['controller'] = $temp[0];
                $r['method'] = $temp[1];
            } else {
                throw new Exception('Wrong binding Controller@method in routes.php', 500);
            }
        } else {throw new Exception('Wrong binding Controller@method in routes.php', 500);}

        if($middleware && is_string($middleware)) {
            $r['middleware'] = $middleware;
        }

        self::$routes[] = $r;
    }

    /**
     * @param $route
     * @param $method
     * @param null $middleware
     * @throws Exception
     */
    public static function get($route, $method, $middleware = null)
    {
        self::add(__FUNCTION__, $route, $method, $middleware);
    }

    /**
     * @param $route
     * @param $method
     * @param null $middleware
     * @throws Exception
     */
    public static function post($route, $method, $middleware = null)
    {
        self::add(__FUNCTION__, $route, $method, $middleware);
    }

    /**
     * @param $route
     * @param $method
     * @param null $middleware
     * @throws Exception
     */
    public static function put($route, $method, $middleware = null)
    {
        self::add(__FUNCTION__, $route, $method, $middleware);
    }

    /**
     * @param $route
     * @param $method
     * @param null $middleware
     * @throws Exception
     */
    public static function patch($route, $method, $middleware = null)
    {
        self::add(__FUNCTION__, $route, $method, $middleware);
    }

    /**
     * @param $route
     * @param $method
     * @param null $middleware
     * @throws Exception
     */
    public static function delete($route, $method, $middleware = null)
    {
        self::add(__FUNCTION__, $route, $method, $middleware);
    }

    /**
     * @return array
     */
    public static function getRoutes(){
        return self::$routes;
    }
}