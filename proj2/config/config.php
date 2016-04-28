<?php

/**
 * The configuration
 * @author Christopher Sidell (csidell1@umbc.edu)
 */

app()->config = [
    //Database MySQL or MariaDB
    'db' => [
        'host' => 'localhost',
        'database' => 'devdb',
        'username' => 'devdb',
        'password' => 'devdb'
    ],
    //Resource directories
    'directories' => [
        'base' => dirname(__FILE__).'/../',
        'public' => dirname(__FILE__).'/../public',
        'resources' => dirname(__FILE__).'/../resources'
    ]
];