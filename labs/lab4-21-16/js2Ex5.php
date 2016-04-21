<?php

session_start();

if(!empty($_POST['drop'])){
    $_SESSION['results'] = empty($_SESSION['results']) ? [$_POST['drop']] : array_merge($_SESSION['results'],[$_POST['drop']]);
}

$results = $_SESSION['results'];

if(empty($results)){
    $results = $_SESSION['results'] = ['Cal Ripken', 'Brooks Robinson', 'Frank Robinson'];
}
?>

<body>
    <form action="js2Ex5.php" method="POST">
        <label>Favorite Orioles</label>
        <input list="drops" name="drop">
        <datalist id="drops">
        </datalist>
        <button type="submit">Submit</button>
    </form>
</body>

<script>
    var options = <?= json_encode($results); ?>;

    for(var key in options){
        document.getElementById('drops').innerHTML += "<option "+
            'value="'+options[key]+'"'+">";
    }
</script>
