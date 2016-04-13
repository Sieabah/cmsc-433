<?php

require_once('config/config.php');

function app(){
    global $app;
    return $app;
}

function config($name = null){
    if(is_null($name)) return null;

    $depth = explode('.', $name);
    
    $curLevel = app()->config;

    foreach($depth as $level){
        if(isset($curLevel[$level])) {
            $curLevel = $curLevel[$level];
        } else {
            return null;
        }
    }

    return $curLevel;
}

function resource_path(){
    return config('directories.resources');
}

function router()
{
    return app()->router;
}

function session(){
    return app()->session;
}

function view(){
    return (new View);
}