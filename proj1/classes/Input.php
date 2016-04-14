<?php

/**
 * Created by IntelliJ IDEA.
 * User: Christopher
 * Date: 4/13/2016
 * Time: 11:48 PM
 */
class Input extends BaseClass
{
    public function __construct()
    {
    }

    public static function input($key, $default){
        if(isset($_POST[$key]))
            return $_POST[$key];
        else
            return $default;
    }
}