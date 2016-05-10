<?php

/**
 * Load.php
 *
 * This simply loads any and all php files in the classes directory, can be improved with an autoloader.
 */

//Load the application container
require_once(dirname(__FILE__).'/classes/App.php');

//Setup helpers
require_once(dirname(__FILE__).'/helpers.php');

//Load configuration
require_once(dirname(__FILE__).'/config/config.php');

//Get the classes directory
$classdir = dirname(__FILE__).'/classes';

//Load all the classfiles
foreach(scandir($classdir) as $class){
    if(in_array($class, ['.','..'])) continue;

    if(endsWith($class, '.php'))
        require_once($classdir.'/'.$class);
}