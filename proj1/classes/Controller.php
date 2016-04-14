<?php

/**
 * Class Controller
 * Base controller class, this is where the router will call functions on pageload
 *
 * @author Christopher Sidell (csidell1@umbc.edu)
 */
class Controller extends BaseClass
{
    /**
     * index
     * The index view
     * @route /
     * @author Christopher Sidell (csidell1@umbc.edu)
     * @return View
     */
    public function index(){
        //Get previous classes
        $sesh = Session::get('taken', []);

        //Get all classes
        $data['allClasses'] = app()->studentclass->getList();

        //Generate available classes
        $data['available'] = app()->studentclass->availableClasses($sesh);

        //Generate a unique taken list and disregard invalid classes
        $data['taken'] = [];
        foreach($sesh as $class){
            //Check if class is valid
            if(!isset($data['allClasses'][$class])){
                unset($sesh[$class]);
                session()->put('taken', $sesh);
            } else
                $data['taken'][$class] = $data['allClasses'][$class];
        }

        $data['hasTaken'] = function($course, $list){
          return app()->studentclass->taken($course, $list);
        };

        //Return view (view.php)
        return view()->make('view', $data);
    }

    /**
     * addclass
     * Add class to taken list
     * @route /add
     * @author Christopher Sidell (csidell1@umbc.edu)
     * @return Redirect
     */
    public function addclass(){
        //See if classlist is set or null
        if(empty(Input::input('classlist', null)))
            return redirect()->back()->exec();

        //Get the classes
        $classes = Input::input('classlist', '');

        //Parse the list
        $parsedClasses = [];
        foreach(explode(',', $classes) as $class){
            $parsedClasses[] = strtolower(trim($class));
        }

        //Push them to the session, merge with previous list
        session()->put('taken', array_merge(session()->get('taken', []),$parsedClasses));

        //Redirect back to the home route
        return redirect()->to('/')->exec();
    }
}