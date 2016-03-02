<?php

class create_prerequisite_table
{
    public function run()
    {
        global $app;

        $app->DB->raw("CREATE TABLE `prerequisites` ("
                        ."`class_id` INT UNSIGNED NULL,"
                        ."`prereq_id` INT UNSIGNED NULL,"
                        ."`or` TINYINT UNSIGNED DEFAULT FALSE,"
                        ."INDEX `class_id_prereq_id` (`class_id`, `prereq_id`));");
    }
}