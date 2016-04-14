<?php

/**
 * Class Redirect
 *
 * Handles redirecting the user to various places
 * @author Christopher Sidell (csidell1@umbc.edu)
 */
class Redirect extends BaseClass
{
    public static $url = null;

    /**
     * exec
     * Execute the redirect
     * @author Christopher Sidell (csidell1@umbc.edu)
     * @return Redirect
     */
    public function exec(){
        if(is_null(self::$url))
            die('No url set!');

        header('Location: '.self::$url);

        return $this;
    }

    /**
     * with
     * Bind the extra value just for the next route
     * @param $key {string} key
     * @param $value {mixed} value
     * @author Christopher Sidell (csidell1@umbc.edu)
     * @return Redirect
     */
    public function with($key, $value){
        Session::put($key, $value);
        return $this;
    }

    /**
     * to
     * Redirect to the following URL
     * @param $url
     * @author Christopher Sidell (csidell1@umbc.edu)
     * @return Redirect
     */
    public function to($url){
        self::$url = $url;

        return $this;
    }

    /**
     * back
     * Redirect back to the referer
     * @author Christopher Sidell (csidell1@umbc.edu)
     * @return Redirect
     */
    public function back(){
        $this->to($_SERVER['HTTP_REFERER']);

        return $this;
    }
}