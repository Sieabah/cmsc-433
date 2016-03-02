<?php

class StudentClass extends DB
{
    protected $table = 'classes';

    public function prerequisite($course){
        global $app;

        return $app->Prerequisite->get($course);
    }

    public function get($course){
        global $app;

        //return $app->DB->query('SELECT * FROM ')
    }
}