<?php

class drop_everything
{
    public function run()
    {
        global $app;

        $tables = [
            'classes', 'prerequisites'
        ];

        foreach($tables as $table){
            $app->DB->raw("DROP TABLE IF EXISTS `".$table."`;");
        }
    }
}