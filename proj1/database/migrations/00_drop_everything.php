<?php

class drop_everything
{
    public function run()
    {
        $tables = [
            'classes', 'prerequisites'
        ];

        foreach($tables as $table){
            app()->db->raw("DROP TABLE IF EXISTS `".$table."`;");
        }
    }
}