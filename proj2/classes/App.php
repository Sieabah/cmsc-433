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

    public static function process(){

    }

    public static function route($uri){
        switch($uri){
            case '/':
                return self::index();
            case 'formProcess':
                return self::process();
            default:
                return [];
        }
    }

    public static function run(){
        if(isset(app()->routes[$_SERVER['REQUEST_URI']])){
            return view()->make(app()->routes[$_SERVER['REQUEST_URI']], self::route($_SERVER['REQUEST_URI']));
        }
        else
            return view()->make($_SERVER['REQUEST_URI']);
    }
}

app()->App = new App;

