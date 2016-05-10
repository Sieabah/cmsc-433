<?php

/**
 * Class Prerequisite
 *
 * Describes the prerequisite model
 * @author Christopher Sidell (csidell1@umbc.edu)
 */
class Prerequisite extends DB
{
    protected $table = 'prerequisites';

    /**
     * Get the prequisites from the DB
     * @param $course {string} Course name
     * @author Christopher Sidell (csidell1@umbc.edu)
     * @return {array}
     */
    public function get($course){
        return app()->db->query(
            'SELECT classes.*, prerequisites.or '
            .'FROM prerequisites '
            .'INNER JOIN classes '
            .'ON prerequisites.prereq_id = classes.id '
            .'WHERE `class_id` = ? ;', [$course])->fetchAll(PDO::FETCH_OBJ);
    }
}

//Load prerequisite into app container
app()->prerequisite = (new Prerequisite);