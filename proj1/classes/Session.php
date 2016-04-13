<?php

class Session extends BaseClass
{
    const inject = true;

    public static function destroy(){
        session_destroy();
    }

    public static function put($key, $val){
        $_SESSION[$key] = $val;
    }

    public static function get($key, $default){
        if(isset($_SESSION[$key]))
            return $_SESSION[$key];
        else
            return $default;
    }
}