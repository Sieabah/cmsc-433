<?php

class Student extends DB
{
    protected $table = 'prerequisites';

    public function get($course){
        global $app;

        return $app->DB->query(
            'SELECT classes.* '
            .'FROM prerequisites '
            .'INNER JOIN classes '
            .'ON prerequisites.prereq_id = classes.id '
            .'WHERE `class_id` = ? ;', [$course])->fetchAll(PDO::FETCH_OBJ);

        //return $app->DB->query('SELECT * FROM ')
    }
}