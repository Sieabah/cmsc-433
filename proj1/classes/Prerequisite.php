<?php

class Prerequisite extends DB
{
    protected $table = 'prerequisites';

    public function get($course){
        return app()->db->query(
            'SELECT classes.* '
            .'FROM prerequisites '
            .'INNER JOIN classes '
            .'ON prerequisites.prereq_id = classes.id '
            .'WHERE `class_id` = ? ;', [$course])->fetchAll(PDO::FETCH_OBJ);

        //return $app->DB->query('SELECT * FROM ')
    }
}