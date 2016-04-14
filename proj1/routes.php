<?php

/**
 * Routes.php This is file is loaded to register the routes to use
 * 
 * @author Christopher Sidell (csidell1@umbc.edu)
 */


router()->route('get', '/', 'Controller@index');

router()->route('post', '/add', 'Controller@addclass');

router()->route('post', '/student', 'Controller@savestudent');