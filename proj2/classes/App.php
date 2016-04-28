<?php

global $app;
$app = (object)[];

function app(){
    global $app;
    return $app;
}

class App{
    public static function run(){
        if(isset(app()->routes[$_SERVER['REQUEST_URI']]))
            return view()->make(app()->routes[$_SERVER['REQUEST_URI']]);
        else
            return view()->make($_SERVER['REQUEST_URI']);
    }
}

app()->App = new App;

