<?php

class StudentClass extends DB
{
    protected $table = 'classes';

    public function prerequisite($course){
        return app()->prerequisite->get($course);
    }

    public function getList(){
        $classes = $this->all();
        
        foreach($classes as $class) {
            $class->prereq = [];
            $prereq = $this->prerequisite($class->id);
            foreach ($prereq as $req) {
                $class->prereq[] = $req;
            }
        }

        return $classes;
    }
    public function get($course){
        global $app;

        //return $app->DB->query('SELECT * FROM ')
    }
}