<?php

global $app;
$app = (object)[];

require_once('helpers.php');

spl_autoload_register(function($class_name){
    include config('directories.base').'classes/'.$class_name.'.php';
});

$directory = dirname(__FILE__).'/classes';
$files = scandir($directory);
foreach($files as $file){
    if(in_array($file, ['.','..'])) continue;

    $name = explode('.', $file)[0];

    if($name::inject)
        $app->$name = new $name(app()->config);
}

router()->build();