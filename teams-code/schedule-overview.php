<?php
require 'config.php';
require 'icon.html';
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
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <title>Schema</title>
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
    <div class="home-main-s">
        <div class="center">
            <div class="home-content">
                <h2>Schema</h2>
                <table class="schedule">
                    <tr class="even-tr">
                        <th class="th-200">Team 1</th>
                        <th class="th-200">Team 2</th>
                        <th class="th-100">Wedstrijd duur</th>
                        <th class="th-100">Pauze duur</th>
                        <th class="th-300">Rust duur</th>
                        <th class="th-50">Veld</th>
                        <th class="th-200">Referee</th>
                        <th class="th-100">Team 1 score</th>
                        <th class="th-100">Team 2 score</th>
                        <?php
                        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
                            if ($user['admin'] == 1) {
                                echo "<th class='th-200'>Eindscore</th>";
                            }
                        }
                        ?>
                    </tr>
                    <?php
                    $scheduleCount = count($schedule);
                    $oddOrEven = 1;
                        for ($i = 0; $i < $scheduleCount; $i++) {
                            if($oddOrEven % 2 == 0){
                                // Even
                                echo '<tr class="even-tr">';
                            }
                            else {
                                // Odd
                                echo '<tr class="odd-tr">';
                            }
                            $oddOrEven++;
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
                    ?>
                </table>
                <?php
                if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
                    if ($user['admin'] == 1){
                        echo "<form action='scheduleController.php' method='post'>";
                        echo "<input type='hidden' name='type' value='delete'>";
                        echo "<input class='form-button' type='submit' value='Verwijder schema'>";
                        echo "</form>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <div class="home-footer">
        <p>Telefoon: 0645871236</p>
        <p>Adres: Terheijdenseweg 350, 4826 AA Breda</p>
        <p>Email: radiuscollege@rocwb.nl</p>
    </div>
</body>
</body>
</html>
