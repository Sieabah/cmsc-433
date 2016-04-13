<!doctype html>
<html>
    <head>
        <title>CMSC 433 - Proj 1</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

        <link rel="stylesheet" type="text/css" href="/css/style.css"/>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-xs-6">
                    <h3>All Available Classes</h3>
                    <ul>
					<?php
						//Make our initial DB connection.
						require("../classes/StudentClass.php");
						$classDB = new StudentClass() or die("Couldn't initialize connection to student database.\n");
					
						//Get the list of all classses.
						$allClasses = $classDB->getList();
						
                        foreach($allClasses as $class) {
                            echo sprintf("\t\t\t\t\t\t<li><strong>%s</strong>%s</li><br>\n", strtoupper($class->course), $class->name);
                        }
					?>
                    </ul>
                </div>
                <div class="col-xs-6">
                    <h3>Classes you can take</h3>
                    <ul>
					<?php
						require("../classes/Session.php");
					
						//Does this student have any classes in their session?
						//If so, pull those to get our next classes.
						$taken = Session::get("taken", array());
						
						//Use that to get available classes.
						$available = $classDB->availableClasses($taken);
						
						//Display the takeable classes now.
                        foreach($available as $class) {
							echo sprintf("\t\t\t\t\t\t<li><strong>%s</strong>%s</li><br>\n", strtoupper($class->course), $class->name);
						}
					?>
                    </ul>
                </div>
            </div>
        </div>
    </body>
    <script src="/js/script.js"></script>
</html>