<?php 
  $DBNAME   = "project1";    //Name of the database
  $HOST     = "localhost";   //Database host. In our case, the localhost
  $USERNAME = "root";        //phpMyAdmin username. Dont abuse root!
  $PASSWORD = "Lupoli#433";  //phpMyAdmin Password
  $errs = [];                //Array to hold error messages. These are printed on screen later
  $db;                       //PDO variable
  $lastQueryResult;          //The res

  try{
    //Establish a connection to the phpmyadmin database using a PDO
    $db = new PDO("mysql:host={$HOST};dbname={$DBNAME};charset=utf8", $USERNAME, $PASSWORD);
  } catch (PDOException $e){
   
    //If there is any connection problem, including invalid credentials, nullify the PDO
    $db=null;

    //add an error message describing a server problem
    $errs []= "Connection to the database could not be established. Please try submitting again later.";
 }


  /**
  * WARNING: This function has NO VALIDATION for the parameter. Be very careful using this function.
  *
  * Truncate a table. All entries in a table are deleted, leaving an empty table
  *
  * @param {String} $tableName
  *   The name of the table to truncate. 
  *
  * @return {PDOStatement}
  *  A PDOStatement which can be used to check the result of the operation
  */
  function truncateTable($tableName){
    $sql = "DELETE FROM ".$tableName." WHERE 1";
    return executeSql($sql);
  }


  /**
  * WARNING: This function is designed to execute ANY SQL that it is provided. Make sure not to nuke your own stuff accidentally.
  *
  * Consolidates mauch of the code necessary to execute a SQL query using PDO 
  *
  * @param {String} $sql
  *   A SQL statement string
  *
  * @param {Array} $params
  *   Optional - An array of values to bind to any placeholder variables in your SQL
  *   For more information on this visit the Php reference here: http://php.net/manual/en/pdo.prepare.php
  *
  * @return {PDOStatement}
  *  A PDOStatement which can be used to check the result of the operation 
  */
  function executeSql($sql, $params = NULL){
    global $db;
    global $lastQueryResult;

    //prepare the sql statement
    $stmt = $db->prepare($sql);

    //if no params were given, execute the statement by itself
    if($stmt && empty($params)){
      $lastQueryResult = $stmt->execute();
      return $stmt;
    }

    //if the $params array isnt empty, bind the params to the sql statement and execute
    $lastQueryResult = $stmt->execute($params);
    return $stmt;
  }


  /**
  * Insert a student into the database. The given data is assumed to be valid 
  *
  * @param {String} $id
  *   The student's campus id
  *
  * @param {String} $name
  *   The student's name
  *
  * @param {String} $email
  *   The student's email
  *
  * @param {String} $contactnum
  *   The student's contact number
  *
  * @return {PDOStatement}
  *  A PDOStatement which can be used to check the result of the operation 
  */
  function insertStudent($id, $name, $email, $contactnum){
    global $db;

    //create an array of the parameters so that they can be bound to the sql query
    $values = array($id, $name, $email, $contactnum);

    //create a sql query for pdo to execute
    $sql = "INSERT INTO students (campusid, name, email, contactnum) VALUES (?, ?, ?, ?)";
    
    //execute the query and return the PDOStatement
    return executeSql($sql, $values);  
  }

  /**
  * Insert a course into the database. The given data is assumed to be valid 
  *
  * @param {String} $id
  *   The course id (for example cmsc201)
  *
  * @param {String} $name
  *   The course title (for example "Computer Science for Majors I")
  *
  * @param {float} $creditHours
  *   The credit value of the course (for example, 4.00). expected to be 3 digits with 2 decimal places 
  *
  * @return {PDOStatement}
  *  A PDOStatement which can be used to check the result of the insertion 
  */
  function insertCourse($id, $name, $creditHours){
    global $db;

    //create an array of the parameters so they can be bound to the sql query
    $values = array($id, $name, $creditHours);

    //create the sql query with placeholders for the data
    $sql = "INSERT INTO courses (courseid, name, credits) VALUES (?, ?, ?)";
    
    //execute the query and return the PDOStatement
    return executeSql($sql, $values);  
  }

  /**
  * Insert a relationship between a student and a course into the database. The given data is assumed to be valid 
  *
  * @param {String} $student_id
  *   The student id (for example "AB11111")
  *
  * @param {String} $course_id
  *   The course id (for example "cmsc201")
  *
  * @return {PDOStatement}
  *  A PDOStatement which can be used to check the result of the insertion 
  */
  function insertTakes($student_id, $course_id){
    global $db;
  
    //create an array from the parameters so they can be bound to the sql query
    $values = array($student_id, $course_id);

    //create the sql query with placeholders for the data
    $sql = "INSERT IGNORE INTO coursestaken (campusid, courseid) VALUES (?, ?)";
    
    //execute the query with the given parameters and return the PDOStatement
    return executeSql($sql, $values);  
  }


  /**
  * Sanitizes a string to prevent XSS attacks and non-standard data
  * 
  * @param {String} $string
  *   A string to sanitize
  *
  * @return {String} The sanitized string
  */
  function sanitize($string){

    //trim whitespace and escape special characters
    $string = trim($string);
    $string = htmlspecialchars($string);
    return $string;
  }


  /**
  * Validates the data from a post request. The other functions in this file should work properly if you call this function first
  * 
  * Validation will sanitize all user's form data, as well as check that data is formatted properly. 
  * It also checks for database connection issues or if the user has already submitted the form. 
  * Basically, this function tries to stop bad things from going through
  *
  * @return {bool} $valid
  *   whether the given data is valid or not. You should not proceed if this isnt true 
  */
  function validatePost(){
    global $errs;
    global $db;
    $valid = true;
 
    //sanitize all of the post variables
    $_POST["name"] = sanitize($_POST["name"]);
    $_POST["email"] = sanitize($_POST["email"]);
    $_POST["contactnum"] = sanitize($_POST["contactnum"]);
    $_POST["campusid"] = sanitize($_POST["campusid"]);

    //make sure the user gave a properly formatted campus id
    if(preg_match('/^[a-zA-Z]{2}[\d]{5}$/', $_POST["campusid"]) !== 1){
      $errs[]= "UMBC campus id must be two letters followed by 5 numbers";
      $valid = false;
    }

    //make sure the user entered a well formatted phone number
    if(preg_match('/^[\d]{10}$/', $_POST["contactnum"]) !== 1){
      $errs[]= "Phone number must consist only of 10 digits";
      $valid = false;
    }

    //make sure the database connection is established
    if(!isset($db)){
      $valid = false;
    }
    //check for duplicate entry in the database
    $select = "SELECT campusid FROM students";
    $result = executeSql($select);
    while($row = $result->fetch()){
       if($row["campusid"]==$_POST["campusid"]){
         $valid = false;
         $errs[]="User has already submitted!";
       }
    }

 
    return $valid;
  }

  /**
  * insert records from the post request into the database. 
  * For the love of all that is good, make sure to call validatePost() before you use this function
  */
  function insertRecords(){

    //insert the student information
    insertStudent($_POST["campusid"], $_POST["name"], $_POST["email"], $_POST["contactnum"]);
  
    //Insert a relationship for each course that user marked as taken
    foreach($_POST["course"] as $course){
      insertTakes($_POST["campusid"], $course);
    }
    
  }

  /**
  * Gets a summary for the table that is created on a successful form submission
  *
  * @return {Array} $result
  *   An associative array of all of the information used in the summary table
  *   For each course that the user has taken, an entry is created in this array. The key is the course id
  *   The value for each key is a subarray with the course title under the key "name" and the course credit value under the key "credits"  
  *   For example, If a user has taken CMSC 201 the following will be the result:  $result["cmsc201"] = ["name"=> "Computer Science for Majors I", "credits"=>"4.00"] 
  */
  function getSummary(){
 
    //result associative array
    $result = [];

    //for every course that the user said they have taken
    foreach($_POST["course"] as $course){

      //grab the course name and credit value from the database
      $sql = "SELECT name, credits FROM courses WHERE courseid = ?";
      $stmt = executeSql($sql, array($course));
      $row = $stmt -> fetch(PDO::FETCH_ASSOC);

      //put the course name and credits as the value of the courseid key of the result array
      $result[$course] = $row;
    }

    //return the result array
    return $result;
  }
 ?>
