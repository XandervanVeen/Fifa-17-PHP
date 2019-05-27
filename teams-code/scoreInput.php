<?php
require 'config.php';
require 'style.php';
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
}
else {
    header("Location: index.php");
}
$sql = "SELECT * FROM users WHERE id = :id";
$prepare = $db->prepare($sql);
$prepare->execute([
    ':id' => $_SESSION['id']
]);
$user = $prepare->fetch(PDO::FETCH_ASSOC);
if ($user['admin'] == 0) {
    header("Location: index.php");
}
$sql = "SELECT * FROM schedule WHERE id = :id";
$prepare = $db->prepare($sql);
$prepare->execute([
    ':id' => $_GET['id']
]);
$schedule = $prepare->fetch(PDO::FETCH_ASSOC);
if (empty($schedule)) {
    header("Location: index.php");
}
$sql = "SELECT * FROM teams";
$query = $db->query($sql);
$teams = $query->fetchAll(PDO::FETCH_ASSOC);
foreach ($teams as $key => $val) {
    if ($val['id'] == $schedule['team1']) {
        $team1 = $val;
    }
}
foreach ($teams as $key => $val) {
    if ($val['id'] == $schedule['team2']) {
        $team2 = $val;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Score input</title>
</head>
<style>
    .teams tr th {
        border: black 1px solid;
        padding: 5px;
    }
</style>
<body>
<a href="schedule-overview.php">Go back</a>
<form action="scheduleController.php" method="post">
    <input type="hidden" name="type" value="scoreInput">
    <input type='hidden' name='id' value='<?=$_GET['id']?>'>
<table class="teams">
    <tr>
        <th style="width: 200px;">Team 1</th>
        <th style="width: 200px;">Team 2</th>
        <th style="width: 200px;">Veld</th>
        <th style="width: 200px;">Team 1 score</th>
        <th style="width: 200px;">Team 2 score</th>
    </tr>
    <tr>
        <?php
            echo "<th>{$team1['name']}</th>";
            echo "<th>{$team2['name']}</th>";
            echo "<th>{$schedule['field']}</th>";
            echo "<th><input type='team1score' id='team1score' name='team1score' value='{$schedule['team1score']}'></th>";
            echo "<th><input type='team2score' id='team2score' name='team2score' value='{$schedule['team2score']}'></th>";
        ?>
    </tr>
</table>
    <input type="submit" value="Update">
</form>
</body>
</html>
