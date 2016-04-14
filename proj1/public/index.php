<?php

/**
 * Entry point for the application
 *
 * @author Christopher Sidell (csidell1@umbc.edu)
 */

//Start the session
session_start();

//For purposes, turn on all errors
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//Load the framework
require_once(dirname(__FILE__).'/../loader.php');

//Launch application
echo app()->router->action($_SERVER['REQUEST_URI']);