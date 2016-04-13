<?php

app()->config = [
    'db' => [
        'host' => 'db.dev',
        'database' => 'cmsc433-proj1',
        'username' => 'devdb',
        'password' => 'devdb'
    ],
    'directories' => [
        'base' => dirname(__FILE__).'/../',
        'public' => dirname(__FILE__).'/../public',
        'resources' => dirname(__FILE__).'/../resources'
    ]
];