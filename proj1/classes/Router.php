<?php

class Router extends BaseClass
{
    const inject = true;

    public function __construct()
    {
        $this->routes = [];
    }

    public function route($method, $route, $action){
        $method = strtoupper($method);

        if(count(explode('@', $action)) != 2) die('INVALID ROUTE');

        if(!isset($this->routes[$method]))
            $this->routes[$method] = [];

        $route = $this->parseRoute($route);

        $this->routes[$method][$route] = $action;
    }

    public function build(){
        $fp = config('directories.base').'/routes.php';

        require_once($fp);
    }
    
    private function parseRoute($route){
        return $route;
    }

    public function action($route){
        $route = $this->parseRoute($route);

        if(isset($this->routes[$_SERVER['REQUEST_METHOD']][$route])) {
            $path = explode('@',$this->routes[$_SERVER['REQUEST_METHOD']][$route]);

            return (new $path[0])->$path[1]();
        }
        else
            return '<h1>404</h1>';
    }
}