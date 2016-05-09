<!doctype html>
<html>
  <head>
    <meta charset="utf8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Computer Science Class List</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="/style.css">
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <a href="/">
            <img src="/img/umbclogo.png" />
          </a>
        </div>
      </div>
      <div class="row">
        <div id="classtree" class="col-xs-12">
          <?php if($errs):?>
            <div class="error">
              <p class="heading">The following errors prevented the data from being processed:</p>

              <?php foreach($errs as $err): ?>
                <p class="bolderr"> <?php echo $err; ?> </p>
              <?php endforeach; ?>
              <a class="fancyLink return" href="/">Use this link to return to the form</a>
            </div>
          <?php else: ?>
            <h1>Your information has been submitted!</h1>
            <h4>When you visit your advisor, they will look up the classes you have taken based on the campus id that you have provided</h4>
            <h4>Your advisor will then discuss potential course options based on this information. Your summary is below: </h4>
            <hr>
            <div class="col-xs-12 col-sm-6">
              <h3>Your summary</h3>
              <table class="summary">
                <tr>
                  <th>Course Taken</th>
                  <th>Credit Value</th>
                </tr>

                <?php
                $totalCredits = 0;
                foreach($summary as $course):
                  $totalCredits += $course->credits;
                  ?>
                  <tr>
                    <td><strong><?= strtoupper($course->course); ?></strong> <?= $course->name ?></td>
                    <td><?= $course->credits; ?></td>
                  </tr>

                <?php endforeach; ?>
                <tr>
                  <td class="boldTot">Total Credits: </td>
                  <td class="boldTot"><?php printf("%1\$.2f", $totalCredits); ?></td>
                </tr>
              </table>
            </div>
            <div class="col-xs-12 col-sm-6">
              <h3>Available courses</h3>
              <table class="summary">
                <tr>
                  <th>Course</th>
                  <th>Credit Value</th>
                </tr>

                <?php
                foreach($canTake as $course):
                  ?>
                  <tr>
                    <td><strong><?= strtoupper($course->course); ?></strong> <?= $course->name ?></td>
                    <td><?= $course->credits; ?></td>
                  </tr>

                <?php endforeach; ?>
              </table>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </body>
</html>
 