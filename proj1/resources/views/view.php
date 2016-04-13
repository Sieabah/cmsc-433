<!doctype html>
<html>
<head>
    <title>CMSC 433 - Proj 1</title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
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
</body>
<script src="script.js"></script>
</html>