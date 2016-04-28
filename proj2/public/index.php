<?php

//Session expires after 24 hours
ini_set('session.gc_maxlifetime', 60*60*24);

//Start the session
session_start();

//For purposes, turn on all errors
error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once(dirname(__FILE__).'/../load.php');

echo app()->App->run();
