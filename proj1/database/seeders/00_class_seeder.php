<?php

/**
 * Class class_seeder
 * Student class seeder
 * @author Christopher Sidell (csidell1@umbc.edu)
 */
class class_seeder
{
    /**
     * run
     * This is called to run the seeder
     * @author Christopher Sidell (csidell1@umbc.edu)
     */
    public function run()
    {
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
                $catalog[$name][$name . $number] = app()->studentclass->create([
                    'name' => $class->name,
                    'course' => $name . $number,
                    'number' => $number,
                    'department' => $name
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
                                app()->prerequisite->create([
                                    'class_id' => $catalog[$name][$course],
                                    'prereq_id' => $req != 'any' ? $catalog[$reqName][$req] : 0,
                                    'or' => $or ? 1 : 0
                                ]);
                        }
                    }
                }
            }
        }
    }
}