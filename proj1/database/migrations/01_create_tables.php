<?php

class create_tables
{
    public function run()
    {
		//Create the class list.
        app()->raw("CREATE TABLE `classes` (`id` INT UNSIGNED NOT NULL AUTO_INCREMENT, "
                        ."`name` CHAR(255) NULL DEFAULT NULL, "
                        ."`course` CHAR(50) NULL DEFAULT NULL, "
                        ."`number` SMALLINT NULL DEFAULT NULL, "
                        ."`department` CHAR(50) NULL DEFAULT NULL, "
                        ."PRIMARY KEY (`id`));");
    }
}
?>