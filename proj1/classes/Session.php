<?php

class Session extends BaseClass
{
    const inject = true;

    public static function destroy(){
        session_destroy();
    }

    public static function put($key, $val = null){
        $_SESSION[$key] = $val;
    }

    public static function push($key, $val = null){
        $arr = self::get($key);
        $arr[] = $val;
        self::put($key, $arr);
    }

    public static function get($key, $default = null){
        if(isset($_SESSION[$key]))
            return $_SESSION[$key];
        else
            return $default;
    }

    public static function forget($key){
        if(is_array($key))
            foreach($key as $name)
                unset($_SESSION[$name]);
        else
            unset($_SESSION[$key]);
    }
}