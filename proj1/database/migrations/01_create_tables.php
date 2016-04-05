<?php

class create_tables
{
    public function run()
    {
        global $app;

		//Create the class list.
        $app->DB->raw("CREATE TABLE `classes` (`id` INT UNSIGNED NOT NULL AUTO_INCREMENT, "
                        ."`name` CHAR(255) NULL DEFAULT NULL, "
                        ."`course` CHAR(50) NULL DEFAULT NULL, "
                        ."`number` SMALLINT NULL DEFAULT NULL, "
                        ."`department` CHAR(50) NULL DEFAULT NULL, "
                        ."PRIMARY KEY (`id`));");
						
		//Create our student list.
		$app->DB->raw("CREATE TABLE `students` (`id` INT UNSIGNED NOT NULL AUTO_INCREMENT, "
						."`firstName` VARCHAR(255) NOT NULL, "
						."`lastName` VARCHAR(255) NOT NULL, "
						."`studentID` VARCHAR(255) NOT NULL, "
						."`email` VARCHAR(255) NOT NULL, "
						."PRIMARY KEY (`id`));");
						
		//Create the student-class junction.
		$app->DB->raw("CREATE TABLE `classes_taken` (`id` INT UNSIGNED NOT NULL AUTO_INCREMENT, "
						."`student_id` INT UNSIGNED NOT NULL, "
						."`class_id` INT UNSIGNED NOT NULL, "
						."PRIMARY KEY (`id`), "
						."FOREIGN KEY (`student_id`) REFERENCES `students`(`id`)," 
						."FOREIGN KEY (`class_id`) REFERENCES `classes`(`id`), "
						."CONSTRAINT unique_class_taken UNIQUE (`student_id`, `class_id`));");
    }
}
?>