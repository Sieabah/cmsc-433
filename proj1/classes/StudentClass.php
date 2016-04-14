<?php

class StudentClass extends DB
{
    protected $table = 'classes';
    
    public function prerequisite($course){
        return app()->prerequisite->get($course);
    }

    public function getList(){
        $classes = $this->all();

        foreach($classes as $key => $class) {
            $class->prereq = [];
            $prereq = $this->prerequisite($class->id);
            foreach ($prereq as $req) {
                $class->prereq[] = $req;
            }

            $classes[strtolower($class->course)] = $class;
            unset($classes[$key]);
        }

        return $classes;
    }

    public function availableClasses($taken){
        $classes = $this->getList();
        $canTake = [];
        $takenList = array_flip($taken);

        foreach($classes as $class){
            $pass = 0;
            foreach($class->prereq as $req){
                if(isset($takenList[$req->course]))
                    $pass++;
            }

            if(count($class->prereq) == $pass && !isset($takenList[$class->course]))
                $canTake[] = $class;
        }

        return $canTake;
    }
    public function get($course){
        global $app;

        //return $app->DB->query('SELECT * FROM ')
    }
}