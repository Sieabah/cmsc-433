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

//Session expires after 24 hours
ini_set('session.gc_maxlifetime', 60*60*24);

//Load the framework
require_once(dirname(__FILE__).'/../loader.php');

//Launch application
echo app()->router->action($_SERVER['REQUEST_URI']);