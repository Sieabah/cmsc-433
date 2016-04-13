<?php


class View extends BaseClass
{
    public function make($path, $vars){
        ob_start();
        
        extract($vars, EXTR_SKIP);
        include(config('directories.resources').'/views/'.implode(explode('.', $path),'/').'.php');

        return ltrim(ob_get_clean());
    }
}