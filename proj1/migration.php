<?php

require_once('loader.php');

class Migration {

    private $folder;

    public function __construct($folder)
    {
        $this->folder = $folder;
    }

    public function migrate($args){
        $folder = $this->folder.'/migrations';

        $files = scandir($folder);
        foreach($files as $file){
            if(in_array($file, ['.','..'])) continue;

            $parts = explode('.', $file);

            if($parts[count($parts)-1] != 'php') continue;

            $class = implode('_', array_slice(explode('_', $parts[0]), 1));

            include_once($folder.'/'.$file);

            try {
                (new $class())->run();
                echo 'Migration: '.$parts[0]." succeeded \n";
            } catch(Exception $e){
                echo $e->getMessage();
                break;
            }
        }

        if(isset($args[0]) && strtolower($args[0]) == 'seed')
            return $this->seed(array_slice($args, 1));

        return 1;
    }

    public function seed($args){
        $folder = $this->folder.'/seeders';

        $files = scandir($folder);
        foreach($files as $file){
            if(in_array($file, ['.','..'])) continue;

            $parts = explode('.', $file);

            if($parts[count($parts)-1] != 'php') continue;

            $class = implode('_', array_slice(explode('_', $parts[0]), 1));

            include_once($folder.'/'.$file);

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