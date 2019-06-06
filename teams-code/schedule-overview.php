<?php
require 'config.php';
require 'style.php';
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $sql = "SELECT * FROM users WHERE id = :id";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':id' => $_SESSION['id']
    ]);
    $user = $prepare->fetch(PDO::FETCH_ASSOC);
}
$sql = "SELECT * FROM schedule";
$query = $db->query($sql);
$schedule = $query->fetchAll(PDO::FETCH_ASSOC);
$sql = "SELECT * FROM teams";
$query = $db->query($sql);
$teams = $query->fetchAll(PDO::FETCH_ASSOC);
$sql = "SELECT * FROM referee";
$query = $db->query($sql);
$referees = $query->fetchAll(PDO::FETCH_ASSOC);
if (empty($schedule)){
    Header('Location: index.php');
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shedule</title>
</head>
<style>
    .schedule tr th {
        border: black 1px solid;
        padding: 5px;
    }
</style>
<body>
<a href="index.php">Go back</a>
<table class="schedule">
    <tr>
        <th style="width: 200px;">Team 1</th>
        <th style="width: 200px;">Team 2</th>
        <th style="width: 100px;">Wedstrijd duur</th>
        <th style="width: 100px;">Pauze duur</th>
        <th style="width: 100px;">Rust duur</th>
        <th style="width: 50px;">Veld</th>
        <th style="width: 50px;">Referee</th>
        <th style="width: 100px;">Team 1 score</th>
        <th style="width: 100px;">Team 2 score</th>
        <?php
        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
            if ($user['admin'] == 1) {
                echo "<th style='width: 200px;'>Eindscore</th>";
            }
        }
        ?>
    </tr>
    <?php
    $scheduleCount = count($schedule);
        for ($i = 0; $i < $scheduleCount; $i++) {
            echo "<tr>";
            foreach ($teams as $key => $val) {
                if ($val['id'] == $schedule[$i]['team1']) {
                    $team1 = $val;
                }
            }
            foreach ($teams as $key => $val) {
                if ($val['id'] == $schedule[$i]['team2']) {
                    $team2 = $val;
                }
            }
            echo "<th>{$team1['name']}</th>";
            echo "<th>{$team2['name']}</th>";
            echo "<th>{$schedule[$i]['matchtime']}</th>";
            echo "<th>{$schedule[$i]['breaktime']}</th>";
            if ($schedule[$i]['resttime'] == 0){
                echo "<th>Geen rust</th>";
            }
            else {
                echo "<th>{$schedule[$i]['resttime']}</th>";
            }
            echo "<th>{$schedule[$i]['field']}</th>";
            foreach ($referees as $key => $val) {
                if ($val['id'] == $schedule[$i]['referee']) {
                    $currentReferee = $val;
                }
            }
            echo "<th>{$currentReferee['name']}</th>";
            echo "<th>{$schedule[$i]['team1score']}</th>";
            echo "<th>{$schedule[$i]['team2score']}</th>";
            if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
                if ($user['admin'] == 1){
                    if($schedule[$i]['hasBeenEdited'] == 0){
                        echo "<th><a href='scoreInput.php?id={$schedule[$i]['id']}'>Eindstand invullen</a></th>";
                    }
                    else{
                        echo "<th>Wedstrijd gespeeld</th>";
                    }
                }
            }
            echo "</tr>";
        }
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        if ($user['admin'] == 1){
            echo "<form action='scheduleController.php' method='post'>";
            echo "<input type='hidden' name='type' value='delete'>";
            echo "<input type='submit' value='Delete schedule'>";
            echo "</form>";
        }
    }
    ?>
</table>
</body>
</html>
