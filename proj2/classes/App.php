<?php

global $app;
$app = (object)[];

function app(){
    global $app;
    return $app;
}

class App{

    public static function index(){
        $data = [];
        $data['catalog'] = app()->studentclass->getList();
        
        return $data;
    }

    public static function run(){
        if(isset(app()->routes[$_SERVER['REQUEST_URI']])){
            $data = [];
            switch($_SERVER['REQUEST_URI']){
                case '/':
                    $data = self::index();
            }
            return view()->make(app()->routes[$_SERVER['REQUEST_URI']], $data);
        }
        else
            return view()->make($_SERVER['REQUEST_URI']);
    }
}

app()->App = new App;

