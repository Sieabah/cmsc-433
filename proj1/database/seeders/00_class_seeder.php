<?php

class class_seeder
{
    public function run()
    {
        $classes = json_decode(file_get_contents(config('directories.resources').'/classes.json'));

        $catalog = [];

        foreach($classes as $name => $department) {
            $catalog[$name] = [];
            foreach ($department as $number => $class) {
                $catalog[$name][$name . $number] = app()->studentclass->create([
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
                            $matches = [];
                            $num = preg_match('/([^\d]+)\d+/', $req, $matches);

                            if($num > 0)
                                $reqName = $matches[1];
                            else
                                $reqName = $name;

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