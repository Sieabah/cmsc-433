<?php


class Controller extends BaseClass
{
    public function index(){
        $sesh = Session::get('taken', []);

        $data['allClasses'] = app()->studentclass->getList($sesh);;
        $data['available'] = app()->studentclass->availableClasses($sesh);

        return view()->make('view', $data);
    }
}