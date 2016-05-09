<?php

require_once(dirname(__FILE__).'/../load.php');

/**
 * REMOVE EXISTING TABLES
 */
//Registered tables
$tables = [
    'classes', 'prerequisites'
];

//Drop them
foreach($tables as $table){
    app()->db->raw("DROP TABLE IF EXISTS `".$table."`;");
}

/**
 * CREATE NEW TABLES
 */

//Create the class list.
app()->db->raw("CREATE TABLE `classes` (`id` INT UNSIGNED NOT NULL AUTO_INCREMENT, "
    ."`name` CHAR(255) NULL DEFAULT NULL, "
    ."`course` CHAR(50) NULL DEFAULT NULL, "
    ."`number` SMALLINT NULL DEFAULT NULL, "
    ."`department` CHAR(50) NULL DEFAULT NULL, "
    ."`credits` SMALLINT NULL DEFAULT NULL, "
    ."PRIMARY KEY (`id`));");

//Create a table with the following parameters
app()->db->raw("CREATE TABLE `prerequisites` ("
    ."`class_id` INT UNSIGNED NULL,"
    ."`prereq_id` INT UNSIGNED NULL,"
    ."`or` TINYINT UNSIGNED DEFAULT FALSE,"
    ."INDEX `class_id_prereq_id` (`class_id`, `prereq_id`));");


//Parse the classes json file
$classes = json_decode(file_get_contents(config('directories.resources').'/classes.json'));

$catalog = [];

//For each classes as department name and class
foreach($classes as $name => $department) {
    //Add it to the catalog
    $catalog[$name] = [];

    //Fill out the data
    foreach ($department as $number => $class) {
        //Create the catalog and push classes to the DB
        $catalog[$name][$name . $number] = app()->db->create('classes',[
            'name' => $class->name,
            'course' => $name . $number,
            'number' => $number,
            'department' => $name,
             
        ]);
    }
}

//Create prerequisite relations
foreach($classes as $name => $department) {
    //For all classes in the department
    foreach ($department as $number => $class) {
        //Get the course name
        $course = strtolower($name.$number);
        //If there are any requirements
        if(isset($class->req)){
            //Cycle through them
            foreach($class->req as $prereq){
                //Handle or cases
                $courses = explode(',',$prereq);

                //If there are or cases
                $or = count($courses) > 1;

                //For each of the courses
                foreach($courses as $req){
                    $matches = [];
                    //Add the class
                    $num = preg_match('/([^\d]+)\d+/', $req, $matches);

                    //Get the correct requirement name
                    if($num > 0)
                        $reqName = $matches[1];
                    else
                        $reqName = $name;

                    //If it exists in the catalog, add the relation
                    if(isset($catalog[$reqName][$req]))
                        app()->db->create('prerequisites',[
                            'class_id' => $catalog[$name][$course],
                            'prereq_id' => $req != 'any' ? $catalog[$reqName][$req] : 0,
                            'or' => $or ? 1 : 0
                        ]);
                }
            }
        }
    }
}