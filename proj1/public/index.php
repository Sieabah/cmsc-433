<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once(dirname(__FILE__).'/../loader.php');

echo app()->Router->action($_SERVER['REQUEST_URI']);