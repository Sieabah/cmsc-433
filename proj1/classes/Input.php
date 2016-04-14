<?php

/**
 * Class Input
 *
 * Handles previous input from POST variable
 * @author Christopher Sidell (csidell1@umbc.edu)
 */
class Input extends BaseClass
{
    /**
     * Input constructor.
     * This is only here because PHP5 allows PHP4 constructors
     */
    public function __construct(){}

    /**
     * input
     * Interface for accessing $_POST
     * @param $key {string} input key
     * @param $default {mixed} Value is key is not set
     * @author Christopher Sidell (csidell1@umbc.edu)
     * @return mixed
     */
    public static function input($key, $default){
        if(isset($_POST[$key]))
            return $_POST[$key];
        else
            return $default;
    }
}