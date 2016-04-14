<?php

/**
 * Class CSClass
 * CS Class model, this is an instance of a CS class
 * @author Christopher Sidell (csidell1@umbc.edu)
 */
class CSClass extends BaseClass {
    protected $classes;

    /**
     * CSClass constructor.
     * Setup the classes variable
     * @author Christopher Sidell (csidell1@umbc.edu)
     * @param $config {Array} Configuration parameters
     */
    public function __construct($config) {
        $this->classes = [];
    }
}