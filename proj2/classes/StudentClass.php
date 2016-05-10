<?php

/**
 * Class StudentClass
 * 
 * Interface with student classes
 * @author Christopher Sidell (csidell1@umbc.edu)
 */
class StudentClass extends DB
{
    protected $table = 'classes';

    /**
     * Get the prerequisite of the course
     * @param $course {string} Course name
     * @author Christopher Sidell (csidell1@umbc.edu)
     * @return mixed
     */
    public function prerequisite($course){
        return app()->prerequisite->get($course);
    }

    /**
     * getList
     * Get list of all classes with their prerequisites
     * @author Christopher Sidell (csidell1@umbc.edu)
     * @return array
     */
    public function getList(){
        $classes = $this->all();

        //For each class
        foreach($classes as $key => $class) {
            $class->prereq = [];
            
            //Get the prereq
            $prereq = $this->prerequisite($class->id);
            
            //Add to the class list
            foreach ($prereq as $req) {
                $class->prereq[] = $req;
            }

            //Instead of numeric, make associative
            $classes[strtolower($class->course)] = $class;
            unset($classes[$key]);
        }

        return $classes;
    }

    /**
     * availableClasses
     * Get a list of available classes given a list of previous classes
     * @param $taken {Array} Array of courses taken
     * @author Christopher Sidell (csidell1@umbc.edu)
     * @return array
     */
    public function availableClasses($taken){
        //Get entire class list
        $classes = $this->getList();
        $canTake = [];
        //Flip so values(names) are now keys
        $takenList = array_flip($taken);

        //Go through each class
        foreach($classes as $class){

            //Determine if we can take the class
            $pass = 0;
            foreach($class->prereq as $req){
                if(isset($takenList[$req->course])) {
                    if($req->or == '1')
                        $pass = count($class->prereq);
                    $pass++;
                }
            }

            //If pass equals prereq count and it isn't already in list
            if(count($class->prereq) == $pass && !isset($takenList[$class->course]))
                $canTake[] = $class;
        }

        return $canTake;
    }

    public function taken($course, $list){
        return isset($list[strtolower($course)]);
    }
}

//Load the studentclass into the app container
app()->studentclass = (new StudentClass);