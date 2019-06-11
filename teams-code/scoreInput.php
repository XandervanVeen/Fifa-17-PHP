<?php
require 'config.php';
require 'icon.html';
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
if ($schedule['hasBeenEdited'] == 1){
    header("Location: schedule-overview.php");
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
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <title>Score invullen</title>
</head>
<body>
    <div class="home-header">
        <a class="home-logo" href="index.php">
            <h1>FIFA 17</h1>
            <img src="img/football.jpg" alt="logo-img">
        </a>
        <nav>
            <a class="return-button" href="index.php"><img src="img/house.png" alt="house-img"><p>Ga terug</p></a>
            <?php
            if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
                echo "<a href='logout.php'>Uitloggen</a>";
            }
            else {
                echo "<a href='login.php'>Login</a>";
                echo "<a href='register.php'>Registreer</a>";
            }
            ?>
        </nav>
    </div>
    <div class="home-main">
        <div class="center">
            <div class="home-content">
                <h2>Score invullen</h2>
                <form action="scheduleController.php" method="post">
                    <input type="hidden" name="type" value="scoreInput">
                    <input type='hidden' name='id' value='<?=$_GET['id']?>'>
                <table class="teams">
                    <tr class="even-tr">
                        <th class="th-200">Team 1</th>
                        <th class="th-200">Team 2</th>
                        <th class="th-200">Veld</th>
                        <th class="th-200">Team 1 score</th>
                        <th class="th-200">Team 2 score</th>
                    </tr>
                    <tr>
                        <?php
                            echo "<th>{$team1['name']}</th>";
                            echo "<th>{$team2['name']}</th>";
                            echo "<th>{$schedule['field']}</th>";
                            echo "<th><input class='s-type-text' type='team1score' id='team1score' name='team1score' value='{$schedule['team1score']}'></th>";
                            echo "<th><input class='s-type-text' type='team2score' id='team2score' name='team2score' value='{$schedule['team2score']}'></th>";
                        ?>
                    </tr>
                </table>
                    <input class='form-button-s' type="submit" value="Update">
                </form>
            </div>
        </div>
    </div>
    <div class="home-footer">
        <p>Telefoon: 0645871236</p>
        <p>Adres: Terheijdenseweg 350, 4826 AA Breda</p>
        <p>Email: radiuscollege@rocwb.nl</p>
    </div>
</body>
</html>
