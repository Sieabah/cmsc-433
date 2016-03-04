<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$config = [
    'db' => [
        'host' => 'db.dev',
        'database' => 'cmsc433-proj1',
        'username' => 'devdb',
        'password' => 'devdb'
    ],
    'directories' => [
        'base' => getcwd(),
        'public' => getcwd().'/public',
        'resources' => getcwd().'/resources'
    ]
];

function config($name){
    $depth = explode('.', $name);

    global $config;

    $curLevel = $config;

    foreach($depth as $level){
        if(isset($curLevel[$level])){
            $curLevel = $curLevel[$level];
        }
    }

    return $curLevel;
}