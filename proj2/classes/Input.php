<?php

/**
 * Class css_Input
 * Give the class an array to reference and this will allow you to access members of the array with helpers.
 */
class css_Input {
    private $internal;

    public function __construct($arr=[])
    {
        $this->internal = $arr;
    }

    public function input($name, $default=null){
        if(isset($this->internal[$name]))
            return $this->internal[$name];
        else
            return $default;
    }

    public function __get($name)
    {
        if(isset($this->internal[$name]))
            return $this->internal[$name];
        else
            return null;
    }
}