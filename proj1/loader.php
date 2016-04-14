<?php
/**
 * Loader
 *
 * This is the heart of the application as it handles setting up the autoloader and
 *  building the application $app container.
 */

//Setup an empty application object
global $app;
$app = (object)[];

//Load the helpers
require_once('helpers.php');

/**
 * Register the autoloader
 * This autoloader will automatically try to resolve the missing class from the classes folder
 */
spl_autoload_register(function($class_name){
    include config('directories.base').'classes/'.$class_name.'.php';
});

//Get the classes directory
$directory = dirname(__FILE__).'/classes';

//Scan the directory
$files = scandir($directory);
foreach($files as $file){
    //Skip recurive directories
    if(in_array($file, ['.','..'])) continue;

    //Explode the filename and get the class name
    $name = explode('.', $file)[0];
    //Get the class name in lowercase
    $lname = strtolower($name);

    //If we inject it into the app container, add it and initialize
    if($name::inject)
        $app->$lname = new $name(app()->config);
}

//Build the routes
router()->build();