<?php

/**
 * Class Session
 *
 * Class to interface with the PHP session
 * @author Christopher Sidell (csidell1@umbc.edu)
 */
class Session
{
    const inject = true;

    /**
     * destroy
     * Destroy the session and everything in it
     * @author Christopher Sidell (csidell1@umbc.edu)
     */
    public static function destroy(){
        session_destroy();
    }

    /**
     * put
     * Put value into the session under key
     * @param $key {string} key
     * @param null $val Value to put in session
     * @author Christopher Sidell (csidell1@umbc.edu)
     */
    public static function put($key, $val = null){
        $_SESSION[$key] = $val;
    }

    /**
     * push
     * Push the value onto an array in the session
     * @param $key {string} key
     * @param null $val Value to put in the array
     * @author Christopher Sidell (csidell1@umbc.edu)
     */
    public static function push($key, $val = null){
        $arr = self::get($key);
        $arr[] = $val;
        self::put($key, $arr);
    }

    /**
     * get
     * Get the value out of the session or return a default value
     * @param $key {string} key
     * @param null $default Value to return if key doesn't exist
     * @author Christopher Sidell (csidell1@umbc.edu)
     * @return mixed
     */
    public static function get($key, $default = null){
        if(isset($_SESSION[$key]))
            return $_SESSION[$key];
        else
            return $default;
    }

    /**
     * forget
     * Forget key or array of keys
     * @param $key {Array|string}
     * @author Christopher Sidell (csidell1@umbc.edu)
     */
    public static function forget($key){
        if(is_array($key))
            foreach($key as $name)
                unset($_SESSION[$name]);
        else
            unset($_SESSION[$key]);
    }
}