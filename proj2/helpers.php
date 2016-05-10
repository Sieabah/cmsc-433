<?php

/**
 * startsWith helper
 * @param $str
 * @param $needle
 * @return bool
 */
function startsWith($str, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($str, $needle, -strlen($str)) !== false;
}

/**
 * endsWith helper
 * @param $str
 * @param $needle
 * @return bool
 */
function endsWith($str, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || (($temp = strlen($str) - strlen($needle)) >= 0 && strpos($str, $needle, $temp) !== false);
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
 * view
 * Create and return a new view instance
 * @return View
 * @author Christopher Sidell (csidell1@umbc.edu)
 */
function view(){
    return (new View);
}

function session(){
    return (new Session);
}