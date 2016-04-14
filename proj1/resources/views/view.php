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
                        <?php foreach($allClasses as $class): ?>

                            <li><strong><?= strtoupper($class->course); ?></strong> <?= $class->name; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="col-xs-6">
                    <div class="row">
                        <h3>Classes you've taken</h3>
                        <form action="/add" method="POST">
                            <textarea class="form-control" name="classlist" rows="10"></textarea>
                            <button class="btn btn-primary btn-lg pull-right" type="submit">Submit</button>
                        </form>
                        <?php if(isset($taken)): ?>
                        <ul>
                            <?php foreach($taken as $class): ?>
                                <li><strong><?= strtoupper($class->course); ?></strong> <?= $class->name; ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <?php endif; ?>
                    </div>
                    <div class="row">
                        <h3>Classes you can take</h3>
                        <ul>
                            <?php foreach($available as $class): ?>
                                <li><strong><?= strtoupper($class->course); ?></strong> <?= $class->name; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script src="/js/script.js"></script>
</html>