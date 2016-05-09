<?php
   /**
   * Inserts records into session after sanitizing them
   *
   * @author Joshua Standiford
   */
  function insertRecords(){
    $ses = new Session();
    if(($errs = Validator::validatePost(new css_Input($_POST))) != null){
      $ses->put("name", $_POST["name"]);
      $ses->put("email", $_POST["email"]);
      $ses->put("phone", $_POST["contactnum"]);
      $ses->put("campusid", $_POST["campusid"]); 
    }

  }


 function getCourseCredits(){
    $db = new DB();
    
    $courseData = $db->query("SELECT course, credits FROM classes")->fetchAll(PDO::FETCH_OBJ);

    foreach($courseData as $val){
      $cArr["$val->course"] = $val->credits;
    }

    return $cArr;
 }

  /**
   * This function grabs pertinent information from database, creates
   * an associative array with course name as key, and credits as val
   * Returns array, containing associative array with credit info based
   * on classes taken.
   * @author Joshua Standiford
   */
  function getSummary(){
    if(isset($_POST["course"])){
      $courses = $_POST["course"];
    }
    else{
      $courses = array();
    }

    $creditArr = array();

    $cArr = getCourseCredits();

    foreach($courses as $class){
      $temp["credits"] = $cArr[$class];  
      $temp["name"] = strtoupper($class);
      array_push($creditArr, $temp);
    }
    return $creditArr;
  }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf8">
    <link rel="stylesheet" href="/classList.css">
    <title>Computer Science Class List</title>
  </head>
  <body>
   <div class="header"> <a href="/"><img src="./img/umbclogo.png"></a></div>
    <div id="classtree">
      <?php if(($errs = Validator::validatePost(new css_Input($_POST))) != null):?>
      <div class="error">
        <p class="heading">The following errors prevented the data from being processed:</p>

        <?php foreach($errs as $err): ?>
          <p class="bolderr"> <?php echo $err; ?> </p>
        <?php endforeach; ?>
        <a class="fancyLink return" href="/">Use this link to return to the form</a>
      </div>
      <?php else: insertRecords(); ?>  
        <p class="heading">Your information has been submitted!</p>
        <p class="bold">When you visit your advisor, they will look up the classes you have taken based on the campus id that you have provided</p>
        <p class="bold">Your advisor will then discuss potential course options based on this information. Your summary is below: </p>
        <hr>
        <table id="summary">
          <tr>
            <th>Course Taken</th>
            <th>Credit Value</th>
          </tr>

          <?php
          $totalCredits = 0;
          $summary = getSummary();
          foreach($summary as $course):
            $totalCredits += $course["credits"];
            ?>
            <tr>
            <td><?php echo $course["name"]; ?></td>
            <td><?php echo $course["credits"]; ?></td>
            </tr>

          <?php endforeach; ?>
          <tr>
            <td class="boldTot">Total Credits: </td>
            <td class="boldTot"><?php printf("%1\$.2f", $totalCredits); ?></td>
          </tr>
        </table>
      <?php endif; ?>
    </div>
  </body>
</html>
 