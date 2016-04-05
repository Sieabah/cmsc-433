<!doctype html>
<!-- Index form for application. -->

<html>
<head>
    <title>CMSC 433 - Proj 1</title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
	<!-- Get list of prereqs specified by POST. -->
		<!-- Is list invalid? -->
			<!-- If so, display error and return to index.php. -->
	
	<!-- Get student info in POST. -->
		<!-- Is student info invalid? -->
			<!-- If so, display error and return to index.php. -->
			
	<!-- Ask database if user data already exists. -->
		<!-- If so, load those existing prereqs. -->
    <div style="word-wrap: break-word">
        <?php
            $classes = $app->StudentClass->all();

            foreach($classes as $class):
                $class->prereq = [];
                $prereq = $app->StudentClass->prerequisite($class->id);
                foreach($prereq as $req) {
                    $class->prereq[] = $req;
                }
            ?>
                <pre><?= print_r($class); ?></pre>
        <?php endforeach; ?>
    </div>
	
	<!-- Merge the two prereq lists. -->
	
	<!-- Get possible classes for next semester. -->
		<!-- If this fails, display error and return to index.php. -->
		
	<!-- Display the next semester classes. -->
	
	<!-- Update the students's taken prereqs. -->
	<!-- Don't forget to tell the user that the student prereqs have been updated! -->
</body>
<script src="script.js"></script>
</html>