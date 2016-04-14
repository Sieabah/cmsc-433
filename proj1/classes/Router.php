<?php

/**
 * Class Router
 *
 * Class that handles URL routing on framework startup
 * @author Christopher Sidell (csidell1@umbc.edu)
 */
class Router extends BaseClass
{
    const inject = true;

    /**
     * Router constructor
     * Setup the empty routes array
     * @author Christopher Sidell (csidell1@umbc.edu)
     */
    public function __construct()
    {
        $this->routes = [];
    }

    /**
     * route
     * Bind the route to the router
     * @param $method {string} Access method GET|POST
     * @param $route {string} Route that triggers
     * @param $action {string} Class and function to call when triggered
     * @author Christopher Sidell (csidell1@umbc.edu)
     */
    public function route($method, $route, $action){
        $method = strtoupper($method);

        //Break apart the action
        if(count(explode('@', $action)) != 2) die('INVALID ROUTE');

        //Define the route method
        if(!isset($this->routes[$method]))
            $this->routes[$method] = [];

        //Parse the route
        $route = $this->parseRoute($route);

        //Set the route in the table
        $this->routes[$method][$route] = $action;
    }


    /**
     * build
     * Build the routing table from the routes file
     * @author Christopher Sidell (csidell1@umbc.edu)
     */
    public function build(){
        $fp = config('directories.base').'/routes.php';

        require_once($fp);
    }

    /**
     * parseRoute
     * Parse the route given, doesn't do anything currently (haven't had a case where it needed it)
     * @param $route {string} Given route
     * @author Christopher Sidell (csidell1@umbc.edu)
     * @return string
     */
    private function parseRoute($route){
        return $route;
    }

    /**
     * action
     * Handle the route given from the framework, execute the controller method
     * @param $route {string} route called
     * @author Christopher Sidell (csidell1@umbc.edu)
     * @return string
     */
    public function action($route){

        //Parse route
        $route = $this->parseRoute($route);

        //Find the route action in the routing table
        if(isset($this->routes[$_SERVER['REQUEST_METHOD']][$route])) {
            //Explode the two halfs of the action
            $path = explode('@',$this->routes[$_SERVER['REQUEST_METHOD']][$route]);

            return (new $path[0])->$path[1]();
        }
        else
            return '<h1>404</h1>';
    }
}