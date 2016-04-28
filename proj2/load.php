<?php

require_once(dirname(__FILE__).'/classes/App.php');

require_once(dirname(__FILE__).'/helpers.php');
require_once(dirname(__FILE__).'/config/config.php');

$classdir = dirname(__FILE__).'/classes';
foreach(scandir($classdir) as $class){
    if(in_array($class, ['.','..'])) continue;

    if(endsWith($class, '.php'))
        require_once($classdir.'/'.$class);
}