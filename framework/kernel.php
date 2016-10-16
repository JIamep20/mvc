<?php

namespace Framework;

use App\Exceptions\Exception;

/**
 * Class Kernel
 * @package Framework
 */
class Kernel
{
    protected
        $uri,
        $routes = [],
        $type = 'GET',
        $param_reg_ex = '([A-z0-9_-]+)'
    ;

    /**
     * Kernel constructor.
     * @param $settings
     */
    public function __construct()
    {
        $this->uri = trim(urldecode(preg_replace('/\?.*/iu', '', $_SERVER['REQUEST_URI'])), '/');
        try {
            $this->getRequestType();
            $this->processRoutes();
        } catch(Exception $ex) {
            http_response_code($ex->getStatusCode());
            echo '<h1>' . $ex->getMessage() . '</h1>';
        }
        catch(\Exception $exx) {
            http_response_code(500);
            echo '<h1>' . $exx->getMessage() . '</h1>';
        }
    }

    /**
     * Method prepares route reg_ex and converts request type(get post update etc) to lower case
     * @param $route
     * @return mixed
     */
    private function prepareRoute($route)
    {
        $route['r'] = trim($route['r'], '/');
        $rgp = [];
        $rgp[] = '@^';
        $rgp[] = preg_replace_callback('@\{' . $this->param_reg_ex . '\}@', function($match) {
            return $this->param_reg_ex;
        }, $route['r']);
        $rgp[] = '/*$@i';

        $route['r'] = join('', $rgp);

        $route['type'] = strtolower($route['type']);

        return $route;
    }

    /**
     * Method looks for matches in routes and uri
     * depending on request type
     * @throws Exception
     */
    private function processRoutes()
    {
        require(BASE_DIR . '/app/routes.php');
        foreach (Router::getRoutes() as $route) {
            $this->routes[] = $this->prepareRoute($route);
        }

        $args = [];

        foreach($this->routes as $route) {
            if(preg_match($route['r'], $this->uri, $args) && $route['type'] === $this->type){
                array_shift($args);
                $this->processController($route, $args);
                return;
            }
        }

        throw new Exception('Method not allowed', 404);
    }

    /**
     * Method starts callback or Controller->method as described in routes.php
     * @param $route
     * @param array $args
     * @throws Exception
     */
    private function processController($route, $args = [])
    {
        if(array_key_exists('middleware', $route))
            array_map(function($item){
                $name = '\\App\\Middleware\\' . $item;
                new $name;
            }, explode('.', $route['middleware']));

        if(is_callable($route['method'])) {
            $route['method']($args);
        } elseif (array_key_exists('controller', $route) && array_key_exists('method', $route)) {
            $className = '\\App\\Controllers\\' . $route['controller'];
            new $className($route['method'], $args);
        } else {
            throw new Exception('No controllers or callbacks found for this route', 403);
        }
    }

    /**
     * Method defines request type depending on $_SERVER['REQUEST_METHOD'] 
     * and existance of hidden fields with method type if 
     * sended from browser request needs custom 
     * type(update, put, patch, delete etc)
     */
    private function getRequestType()
    {
        $type = $_SERVER['REQUEST_METHOD'];
        $this->type = strtolower(
            $type === 'GET' ? 'GET' :
                ($type === 'POST' ? (isset($_POST['_method']) ? $_POST['_method'] : 'POST') :
                    $type)
        );
    }

}