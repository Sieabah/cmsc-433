<?php

/**
 * Class View
 *
 * This class is responsible for building the view that is returned to the user
 * @author Christopher Sidell (csidell1@umbc.edu)
 */
class View
{
    /**
     * make
     * Make the view
     * @param $path {string} path to the view
     * @param $vars {array} variables to pass to the array
     * @author Christopher Sidell (csidell1@umbc.edu)
     * @return string
     */
    public function make($path, $vars = []){
        //Obstruct the echo buffer
        ob_start();

        //Pass variables to next view
        extract($vars, EXTR_SKIP);

        //Include the view (build the url from dot syntax)
        include(config('directories.resources').'/views/'.implode(explode('.', $path),'/').'.php');

        //Left trim and return entire buffer to caller
        return ltrim(ob_get_clean());
    }
}