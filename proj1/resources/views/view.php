<!doctype html>
<html>
<head>
    <title>CMSC 433 - Proj 1</title>
    <link rel="stylesheet" type="text/css" href="/css/style.css"/>
</head>
<body>
    <div style="word-wrap: break-word">
        <?php
            $classes = app()->studentclass->all();

            foreach($classes as $class):
                $class->prereq = [];
                $prereq = app()->studentclass->prerequisite($class->id);
                foreach($prereq as $req) {
                    $class->prereq[] = $req;
                }
            ?>
                <pre><?= print_r($class); ?></pre>
        <?php endforeach; ?>
    </div>
</body>
<script src="/js/script.js"></script>
</html>