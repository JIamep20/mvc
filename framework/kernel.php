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
        $route['route'] = trim($route['r'], '/');
        $rgp = [];
        $rgp[] = '@^';
        $rgp[] = preg_replace_callback('@{' . $this->param_reg_ex . '}@', function($match) {
            return $this->param_reg_ex;
        }, $route['route']);
        $rgp[] = '/*$@i';

        $route['route'] = join('', $rgp);

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
            if(preg_match($route['route'], $this->uri, $args) && $route['type'] === $this->type){
                array_shift($args);

                $params_names = null;
                preg_match_all('@{' . $this->param_reg_ex . '}@', $route['r'], $params_names);

                $params_names = $params_names[1];

                $this->processController($route, array_combine($params_names, $args));
                return;
            }
        }

        throw new Exception('Method not allowed', 404);
    }

    /**
     * Method starts middlewares, callback or Controller->method as described in routes.php
     * @param $route
     * @param array $args
     * @throws Exception
     */
    private function processController($route, $args = [])
    {
        if(array_key_exists('middleware', $route)){
            array_map(function($item){
                $name = '\\App\\Middleware\\' . $item;
                new $name;
            }, explode('.', $route['middleware']));
        }

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
     * and existance of hidden inputs with method type, if
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