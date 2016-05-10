<?php

/**
 * Class Validator
 * This handles validation at a global level, essentially this exists purely because formProcess did this directly
 *  in the view beforehand.
 *
 * @author Christopher Sidell (csidell1@umbc.edu)
 */
class Validator {
    /**
     * Sanitizes a string to prevent XSS attacks and non-standard data
     *
     * @param {String} $string
     *   A string to sanitize
     *
     * @return {String} The sanitized string
     */
    public static function sanitize($string){
        //trim whitespace and escape special characters
        return htmlspecialchars(trim($string));
    }

    /**
     * Validates the data from a post request. The other functions in this file should work properly if you call this function first
     *
     * Validation will sanitize all user's form data, as well as check that data is formatted properly.
     * It also checks for database connection issues or if the user has already submitted the form.
     * Basically, this function tries to stop bad things from going through
     *
     * @return {array} $valid
     *   Given array of errors or null if validation passed
     *
     * Updates @author Christopher Sidell (csidell1@umbc.edu)
     */
    public static function validatePost(css_Input $input){
        $errs = [];
        //sanitize all of the post variables
        $name = self::sanitize($input->input('name', null));
        $email = self::sanitize($input->input('email', null));
        $number = self::sanitize($input->input('contactnum', null));
        $id = self::sanitize($input->input('campusid', null));

        //make sure the user gave a properly formatted campus id
        if(preg_match('/^[a-zA-Z]{2}[\d]{5}$/', $_POST["campusid"]) !== 1){
            $errs[]= "UMBC campus id must be two letters followed by 5 numbers";
        }

        //make sure the user entered a well formatted phone number
        if(preg_match('/^[\d]{10}$/', $_POST["contactnum"]) !== 1){
            $errs[]= "Phone number must consist only of 10 digits";
        }
        
        return count($errs) > 0 ? $errs : null;
    }
}