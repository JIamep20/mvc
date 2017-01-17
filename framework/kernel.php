<?php

namespace Framework;

/**
 * Class Kernel
 * @package Framework
 */
class Kernel
{
    protected
        $uri,
        $params = [],
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
            $this->get_request_type();
            $this->process_routes();
        } catch(Exception $ex) {
            http_response_code($ex->getStatusCode());
            render('error', ['code' => $ex->getStatusCode(), 'message' => $ex->getMessage()]);
        }
        catch(\Exception $exx) {
            http_response_code(500);
            render('error', ['code' => 500, 'message' => $exx->getMessage()]);
        }
    }

    /**
     * Method prepares route reg_ex and converts request type(get post update etc) to lower case
     * @param $route
     * @return mixed
     */
    private function prepare_route($route)
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
     * @throws Exception\
     */
    private function process_routes()
    {
        require(BASE_DIR . '/app/routes.php');
        foreach (Router::getRoutes() as $route) {
            $this->routes[] = $this->prepare_route($route);
        }

        $args = [];

        foreach($this->routes as $route) {
            if(preg_match($route['route'], $this->uri, $args) && $route['type'] === $this->type){
                array_shift($args);

                $params_names = null;
                preg_match_all('@{' . $this->param_reg_ex . '}@', $route['r'], $params_names);

                $params_names = $params_names[1];

                array_map(function($item) use ($route){
                    if(preg_match('/^\d/', $item) === 1) {
                        throw new Exception('Route parameter can not start with number: ' . $route['r'] , 500);
                    }
                }, $params_names);
                $this->process_controller($route, $args, $this->params);
                return;
            }
        }

        throw new \Framework\Exception('Method not allowed', 404);
    }

    /**
     * Method starts middlewares, callback or Controller->method as described in routes.php
     * @param $route
     * @param array $args
     * @throws Exception\
     */
    private function process_controller($route, $params = [], $request = [])
    {
        if(array_key_exists('middleware', $route)){
            array_map(function($item){
                $name = '\\App\\Middleware\\' . $item;
                if(!class_exists($name)) {
                    throw new Exception('Middleware ' . $name . ' not found');
                }
                new $name;
            }, explode('.', $route['middleware']));
        }

        $params = $this->make_object_from_array($params);
        $request = $this->make_object_from_array($request);

        if(is_callable($route['method'])) {

            if($res = $route['method']($params, $request))
                echo '<pre style="word-wrap: break-word; white-space: pre-wrap;">' . json_encode($res) . '</pre>';

        } elseif (array_key_exists('controller', $route) && array_key_exists('method', $route)) {
            $className = '\\App\\Controllers\\' . $route['controller'];

            if(!class_exists($className)) {
                throw new Exception('Controller ' . $className . ' not found');
            }

            new $className($route['method'], $params, $request);
        } else {
            throw new \Framework\Exception('No controllers or callbacks found for this route', 403);
        }
    }

    /**
     * Method defines request type depending on $_SERVER['REQUEST_METHOD'] 
     * and existance of hidden inputs with method type, if
     * sended from browser request needs custom 
     * type(update, put, patch, delete etc)
     */
    private function get_request_type()
    {
        $type = $_SERVER['REQUEST_METHOD'];
        $this->type = strtolower(
            $type === 'GET' ? 'GET' :
                ($type === 'POST' ? (isset($_POST['_method']) ? $_POST['_method'] : 'POST') :
                    $type)
        );

        if ($this->type === 'get') {
            $this->params = $_REQUEST;
        } else {
            parse_str(file_get_contents('php://input'), $this->params);
        }

        unset($this->params['_method']);
        unset($this->params['uri']);
    }

    /**
     * @param $array
     * @param bool $through_json
     * @return mixed|object
     */
    private function make_object_from_array($array) {
        #TODO ctype_digit
        return (object)$array;
    }

}