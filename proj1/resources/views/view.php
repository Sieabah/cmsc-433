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
                    <h5><em>Classes you have taken will be <strong>highlighted</strong></em></h5>
                    <ul>
                        <?php foreach($allClasses as $class): ?>
                            <li class="<?= $hasTaken($class->course, $taken) ? 'taken' : ''; ?>"><strong><?= strtoupper($class->course); ?></strong> <?= $class->name; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="col-xs-6">
                    <div class="row">
                        <h3>Classes you've taken</h3>
                        <?php if(isset($taken) && false): ?>
                            <ul>
                                <?php foreach($taken as $class): ?>
                                    <li><strong><?= strtoupper($class->course); ?></strong> <?= $class->name; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <!--<p><strong>None!</strong></p>-->
                        <?php endif; ?>
                        <p>Add more? Enter them below in a comma delimited list, enter the full course name</p>
                        <form action="/add" method="POST">
                            <textarea required class="form-control" name="classlist" rows="10"></textarea>
                            <button class="btn btn-primary btn-lg pull-right" type="submit">Submit</button>
                        </form>
                    </div>
                    <div class="row">
                        <h3>Classes you can take</h3>
                        <ul>
                            <?php foreach($available as $class): ?>
                                <li><strong><?= strtoupper($class->course); ?></strong> <?= $class->name; ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="col-xs-12">
                            <h4>Science Paths</h4>
                            <p>
                                <span class="<?= $hasTaken('CHEM101', $taken) ? 'taken' : ''; ?>">CHEM 101</span> ->
                                <span class="<?= $hasTaken('CHEM102', $taken) ? 'taken' : ''; ?>">CHEM 102</span> ->
                                <span class="<?= $hasTaken('CHEM102L', $taken) ? 'taken' : ''; ?>">CHEM 102L</span> ->
                                <span class="<?= $hasTaken('GES110', $taken) ? 'taken' : ''; ?>">GES 110</span>
                            </p>
                            <p>
                                <span class="<?= $hasTaken('CHEM101', $taken) ? 'taken' : ''; ?>">CHEM 101</span> ->
                                <span class="<?= $hasTaken('CHEM102', $taken) ? 'taken' : ''; ?>">CHEM 102</span> ->
                                <span class="<?= $hasTaken('BIOL141', $taken) ? 'taken' : ''; ?>">BIOL 141</span> ->
                                <span>any Lab</span>
                            </p>
                            <p>
                                <span class="<?= $hasTaken('BIOL141', $taken) ? 'taken' : ''; ?>">BIOL 141</span> ->
                                <span class="<?= $hasTaken('BIOL142', $taken) ? 'taken' : ''; ?>">BIOL 142</span> ->
                                <span>BIOL Lab</span> ->
                                <span class="<?= $hasTaken('PHYS121', $taken) ? 'taken' : ''; ?>">PHYS 121</span>
                            </p>
                            <p>
                                <span class="<?= $hasTaken('PHYS121', $taken) ? 'taken' : ''; ?>">PHYS 121</span> ->
                                <span class="<?= $hasTaken('PHYS122', $taken) ? 'taken' : ''; ?>">PHYS 122</span> ->
                                <span class="<?= $hasTaken('GES286', $taken) ? 'taken' : ''; ?>">GES 286</span>
                            </p>
                            <p>
                                <span class="<?= $hasTaken('PHYS121', $taken) ? 'taken' : ''; ?>">PHYS 121</span> ->
                                <span class="<?= $hasTaken('PHYS122', $taken) ? 'taken' : ''; ?>">PHYS 122</span> ->
                                <span class="<?= $hasTaken('PHYS122L', $taken) ? 'taken' : ''; ?>">PHYS 122L</span> ->
                                <span class="<?= $hasTaken('MATH251', $taken) ? 'taken' : ''; ?>">MATH 251</span>
                            </p>
                            <p>
                                <span class="<?= $hasTaken('SCI100', $taken) ? 'taken' : ''; ?>">SCI 100</span> ->
                                <span class="<?= $hasTaken('GES110', $taken) ? 'taken' : ''; ?>">GES 110</span> or
                                <span class="<?= $hasTaken('GES120', $taken) ? 'taken' : ''; ?>">GES 120</span> ->
                                <span class="<?= $hasTaken('SCI101L', $taken) ? 'taken' : ''; ?>">SCI 101L</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script src="/js/script.js"></script>
</html>