<?php

require_once('config.php');

global $app;
$app = (object)[];

spl_autoload_register(function($class_name){
    include 'classes/'.$class_name.'.php';
});

$directory = 'classes';
$files = scandir($directory);
foreach($files as $file){
    if(in_array($file, ['.','..'])) continue;

    $name = explode('.', $file)[0];

    if($name::inject)
        $app->$name = new $name($config);
}

$app->config = $config;