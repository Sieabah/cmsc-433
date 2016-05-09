<?php
 
  function insertRecords(){
    $_SESSION["name"] = $_POST["name"];
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["phone"] =  $_POST["contactnum"];
    $_SESSION["campusid"] = $_POST["campusid"];    
  }


  function getSummary(){
    $courses = $_POST["course"];
    $db = new DB();
    $courseData = $db->query("SELECT * FROM classes")->fetchAll(PDO::FETCH_OBJ);
    foreach($courseData as $val){
      echo($val->course . "<br />");
    }
    
    foreach($courses as $val){
      echo($val . "<br />");
      
    }
  }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf8">
    <link rel="stylesheet" href="../../public/classList.css">
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
 