<?php

class class_seeder
{
    public function run()
    {
        $classes = json_decode(file_get_contents(resource_path().'/classes.json'));

        $catalog = [];

        foreach($classes as $name => $department) {
            $catalog[$name] = [];
            foreach ($department as $number => $class) {
                $catalog[$name][$name . $number] = $app->StudentClass->create([
                    'name' => $class->name,
                    'course' => $name . $number,
                    'number' => $number,
                    'department' => $name
                ]);
            }
        }


        foreach($classes as $name => $department) {
            foreach ($department as $number => $class) {
                $course = strtolower($name.$number);
                if(isset($class->req)){
                    foreach($class->req as $prereq){
                        $courses = explode(',',$prereq);

                        $or = count($courses) > 1;

                        foreach($courses as $req){
                            app()->prerequisite->create([
                                'class_id' => $catalog[$name][$course],
                                'prereq_id' => $req != 'any' ? $catalog[$name][$req] : 0,
                                'or' => $or ? 1 : 0
                            ]);
                        }
                    }
                }
            }
        }
    }
}