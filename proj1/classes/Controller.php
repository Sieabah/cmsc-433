<?php


class Controller extends BaseClass
{
    public function index(){
        $sesh = Session::get('taken', []);

        $data['allClasses'] = app()->studentclass->getList($sesh);
        $data['available'] = app()->studentclass->availableClasses($sesh);

        return view()->make('view', $data);
    }

    public function addclass(){
        if(empty(Input::input('classlist', null)))
            return redirect()->back()->exec();

        $classes = Input::input('classlist', '');

        $parsedClasses = [];
        foreach(explode(',', $classes) as $class){
            $parsedClasses[] = strtolower(trim($class));
        }

        session()->put('taken', $parsedClasses);

        return redirect()->to('/')->exec();
    }
}