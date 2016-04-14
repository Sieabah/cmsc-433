<?php

/**
 * Helpers
 *
 * This is the universal helpers that help make the code easier and simpler to write
 * @author Christopher Sidell (csidell1@umbc.edu)
 */

//Include config variables
require_once('config/config.php');

/**
 * Return the global app container
 * @return object
 * @author Christopher Sidell (csidell1@umbc.edu)
 */
function app(){
    global $app;
    return $app;
}

/**
 * config
 * Get the configuration value
 * @param null $name {string} The string/path of the configuration value
 * @return null
 * @author Christopher Sidell (csidell1@umbc.edu)
 */
function config($name = null){
    if(is_null($name)) return null;

    //Break the dot syntax if it's there
    $depth = explode('.', $name);
    
    $curLevel = app()->config;

    //Get the value in the configuration
    foreach($depth as $level){
        if(isset($curLevel[$level])) {
            $curLevel = $curLevel[$level];
        } else {
            return null;
        }
    }

    return $curLevel;
}

/**
 * resource_path
 * Return the resource path
 * @deprecated
 * @return null
 * @author Christopher Sidell (csidell1@umbc.edu)
 */
function resource_path(){
    return config('directories.resources');
}

/**
 * router
 * Get the router instance
 * @return Router
 * @author Christopher Sidell (csidell1@umbc.edu)
 */
function router()
{
    return app()->router;
}

/**
 * session
 * Get the session instance
 * @return Session
 * @author Christopher Sidell (csidell1@umbc.edu)
 */
function session(){
    return app()->session;
}

/**
 * view
 * Create and return a new view instance
 * @return View
 * @author Christopher Sidell (csidell1@umbc.edu)
 */
function view(){
    return (new View);
}

/**
 * redirect
 * Create and return a new redirect instance
 * @return Redirect
 * @author Christopher Sidell (csidell1@umbc.edu)
 */
function redirect(){
    return (new Redirect());
}