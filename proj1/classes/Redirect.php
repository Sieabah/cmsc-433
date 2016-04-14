<?php

/**
 * Created by IntelliJ IDEA.
 * User: Christopher
 * Date: 4/14/2016
 * Time: 12:01 AM
 */
class Redirect extends BaseClass
{
    public static $url = null;

    public function exec(){
        if(is_null(self::$url))
            die('No url set!');

        header('Location: '.self::$url);
        
        return $this;
    }

    public function with($key, $value){
        Session::put($key, $value);
    }

    public function to($url){
        self::$url = $url;

        return $this;
    }

    public function back(){
        $this->to($_SERVER['HTTP_REFERER']);

        return $this;
    }
}