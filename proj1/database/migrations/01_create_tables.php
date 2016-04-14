<?php

/**
 * Class create_tables
 * Create the class table
 * @author Christopher Sidell (csidell1@umbc.edu)
 */
class create_tables
{
    /**
     * run
     * This is called when migration is run
     * @author Christopher Sidell (csidell1@umbc.edu)
     */
    public function run()
    {
		//Create the class list.
        app()->db->raw("CREATE TABLE `classes` (`id` INT UNSIGNED NOT NULL AUTO_INCREMENT, "
                        ."`name` CHAR(255) NULL DEFAULT NULL, "
                        ."`course` CHAR(50) NULL DEFAULT NULL, "
                        ."`number` SMALLINT NULL DEFAULT NULL, "
                        ."`department` CHAR(50) NULL DEFAULT NULL, "
                        ."PRIMARY KEY (`id`));");
    }
}
?>