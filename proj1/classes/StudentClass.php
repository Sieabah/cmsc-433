<?php

class StudentClass extends DB
{
    protected $table = 'classes';

    public function prerequisite($course){
        return app()->prerequisite->get($course);
    }

    public function get($course){
        global $app;

        //return $app->DB->query('SELECT * FROM ')
    }
}