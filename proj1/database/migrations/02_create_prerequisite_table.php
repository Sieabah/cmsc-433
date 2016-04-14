<?php

/**
 * Class create_prerequisite_table
 * Create the prerequisite table for classes
 * @author Christopher Sidell (csidell1@umbc.edu)
 */
class create_prerequisite_table
{
    /**
     * run
     * This is called to run the migration
     * @author Christopher Sidell (csidell1@umbc.edu)
     */
    public function run()
    {
        //Create a table with the following parameters
        app()->db->raw("CREATE TABLE `prerequisites` ("
                        ."`class_id` INT UNSIGNED NULL,"
                        ."`prereq_id` INT UNSIGNED NULL,"
                        ."`or` TINYINT UNSIGNED DEFAULT FALSE,"
                        ."INDEX `class_id_prereq_id` (`class_id`, `prereq_id`));");
    }
}