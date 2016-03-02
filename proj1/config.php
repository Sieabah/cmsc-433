<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$config = (object)[
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