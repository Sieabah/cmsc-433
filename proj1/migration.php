<?php

/**
 * Database Migrations
 *
 * This file will scan the migrations folder for any php file and immediately try to run it. In doing so
 * will allow you to script setting up the database from scratch.
 *
 * This file will also run seeders, which put data into the database.
 *
 * @author Christopher Sidell (csidell1@umbc.edu)
 */
require_once('loader.php');

/**
 * Class Migration
 * Implementation of the migration and seeder paradigm
 * @author Christopher Sidell (csidell1@umbc.edu)
 */
class Migration {

    //The folder in which the migrations and seeders exist
    private $folder;

    public function __construct($folder)
    {
        $this->folder = $folder;
    }

    /**
     * migrate
     * Run the migrations
     * @param $args {Array} Arguments passed from the commandline
     * @return int
     * @author Christopher Sidell (csidell1@umbc.edu)
     */
    public function migrate($args){
        $folder = $this->folder.'/migrations';

        //Scan the migrations directory for files
        $files = scandir($folder);
        foreach($files as $file){
            //Skip the recursive directories
            if(in_array($file, ['.','..'])) continue;

            //Split apart the filename
            $parts = explode('.', $file);

            //Only care about the php files
            if($parts[count($parts)-1] != 'php') continue;

            //Generate the class name from \d_(\w+_)+.php
            $class = implode('_', array_slice(explode('_', $parts[0]), 1));

            //Include that file
            include_once($folder.'/'.$file);

            //Try to run the migration
            try {
                (new $class())->run();
                echo 'Migration: '.$parts[0]." succeeded \n";
            } catch(Exception $e){
                echo $e->getMessage();
                break;
            }
        }

        //Are we seeding as well?
        if(isset($args[0]) && strtolower($args[0]) == 'seed')
            return $this->seed(array_slice($args, 1));

        return 1;
    }

    /**
     * seed
     * Run all the seeders
     * @param $args {Array} Commandline arguments
     * @return int
     * @author Christopher Sidell (csidell1@umbc.edu)
     */
    public function seed($args){
        $folder = $this->folder.'/seeders';

        //Scan the seeder directory
        $files = scandir($folder);
        foreach($files as $file){
            //Skip recursive directories
            if(in_array($file, ['.','..'])) continue;

            $parts = explode('.', $file);

            //Only care about php files
            if($parts[count($parts)-1] != 'php') continue;

            //Get the class name
            $class = implode('_', array_slice(explode('_', $parts[0]), 1));

            include_once($folder.'/'.$file);

            //Run the seeder
            try {
                (new $class())->run();
                echo 'Seeder: '.$parts[0]." succeeded \n";
            } catch(Exception $e){
                echo $e->getMessage();
                break;
            }
        }

        return 1;

    }

}

(new Migration(config('directories.base').'database'))->migrate(array_slice($argv, 1));