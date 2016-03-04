<?php

require_once('config/config.php');

function config($name = null){
    if(is_null($name)) return null;

    $depth = explode('.', $name);

    global $config;

    $curLevel = $config;

    foreach($depth as $level){
        if(isset($curLevel[$level])){
            $curLevel = $curLevel[$level];
        }
    }

    return $curLevel;
}

function resource_path(){
    return config('directories.resources');
}