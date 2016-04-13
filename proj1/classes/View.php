<?php


class View extends BaseClass
{
    public function make($path){
        $route = explode('.', $path);

        $absPath = config('directories.resources').'/views/'.implode($route,'/').'.php';

        include($absPath);

        return;
    }
}