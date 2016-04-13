<?php

class Session extends BaseClass
{
    const inject = true;

    public function destroy(){
        session_destroy();
    }

    public function put($key, $val){
        $_SESSION[$key] = $val;
    }

    public function get($key, $default){
        if(isset($_SESSION[$key]))
            return $_SESSION[$key];
        else
            return $default;
    }
}