<?php

global $app;
$app = (object)[];

/**
 * Global application reference helper
 * @author Christopher Sidell (csidell1@umbc.edu)
 * @return object
 */
function app(){
    global $app;
    return $app;
}

/**
 * Class App
 * The base framework class that holds references and routing
 * @author Christopher Sidell (csidell1@umbc.edu)
 */
class App{

    /**
     * Controller method for the index page
     * @author Christopher Sidell (csidell1@umbc.edu)
     * @return array
     */
    public static function index(){
        $data = [];

        //Return data for catalog
        $data['catalog'] = app()->studentclass->getList();
        
        return $data;
    }

    /**
     * Controller method for form processing
     * @author Christopher Sidell (csidell1@umbc.edu)
     * @return array
     */
    public static function process(){
        $data = [];
        $input = new css_Input($_POST);

        $errs = Validator::validatePost($input);
        $data['errs'] = $errs = !empty($errs) ? $errs : null;

        /**
         * Inserts records into session after sanitizing them
         * @author Joshua Standiford
         */
        if(is_null($errs)){
            $fields = ['name', 'email', 'phone', 'campusid'];
            
            foreach($fields as $field){
                session()->put('field', $input->input($field, null));
            }

            /**
             * This function grabs pertinent information from database, creates
             * an associative array with course name as key, and credits as val
             * Returns array, containing associative array with credit info based
             * on classes taken.
             * @author Joshua Standiford
             */
            $courses = $input->input('course', []);
            $creditArr = [];
            $catalog = app()->studentclass->getList();

            $taken = [];
            foreach($courses as $class){
                if(isset($catalog[$class])) {
                    $taken[] = $catalog[$class]->course;
                    $creditArr[] = $catalog[$class];
                }
            }

            $data['canTake'] = app()->studentclass->availableClasses($taken);
            $data['summary'] = $creditArr;
        }
        
        return $data;
    }

    /**
     * Very simple naive router
     * @author Christopher Sidell (csidell1@umbc.edu)
     * @param $uri URI of the route
     * @return array
     */
    public static function route($uri){
        switch($uri){
            case '/':
                return self::index();
            case '/formProcess':
                return self::process();
            default:
                return [];
        }
    }

    /**
     * This handles running the router and gathering the data up for making the view
     * @author Christopher Sidell (csidell1@umbc.edu)
     * @return string
     */
    public static function run(){
        if(isset(app()->routes[$_SERVER['REQUEST_URI']])){
            return view()->make(app()->routes[$_SERVER['REQUEST_URI']], self::route($_SERVER['REQUEST_URI']));
        }
        else
            return view()->make($_SERVER['REQUEST_URI'], self::route($_SERVER['REQUEST_URI']));
    }
}

//Load the application class into the app container
app()->App = new App;

