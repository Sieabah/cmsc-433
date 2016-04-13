<?php


class Controller extends BaseClass
{
    public function index(){
        return view()->make('view', ['list' => app()->studentclass->getList()]);
    }
    
    
}