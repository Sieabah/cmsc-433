<?php

/**
 * Class drop_everything
 * Drop everything from the previous database
 * @author Christopher Sidell (csidell1@umbc.edu)
 */
class drop_everything
{
    /**
     * run
     * This is call when migration is run
     * @author Christopher Sidell (csidell1@umbc.edu)
     */
    public function run()
    {
        //Registered tables
        $tables = [
            'classes', 'prerequisites'
        ];

        //Drop them
        foreach($tables as $table){
            app()->db->raw("DROP TABLE IF EXISTS `".$table."`;");
        }
    }
}