<?php
require 'config.php';
require 'style.php';
session_start();

// Retrieve all users
$sql = "SELECT * FROM users";
$query = $db->query($sql);
$users = $query->fetchAll(PDO::FETCH_ASSOC);
$countUsers = count($users);

// Retrieve current session user
$sql = "SELECT * FROM users WHERE id = :id";
$prepare = $db->prepare($sql);
$prepare->execute([
    ':id' => htmlentities($_SESSION['id'])
]);
$user = $prepare->fetch(PDO::FETCH_ASSOC);

// Retrieve all schedule
$sql = "SELECT * FROM schedule";
$query = $db->query($sql);
$schedule = $query->fetchAll(PDO::FETCH_ASSOC);

if (!empty($schedule)){
    header('Location: index.php');
    exit;
}

// Retrieve team where creator is current user
$sql = "SELECT * FROM teams WHERE id = :id";
$prepare = $db->prepare($sql);
$prepare->execute([
    ':id' => $_GET['id']
]);
$team = $prepare->fetch(PDO::FETCH_ASSOC);

if (empty($team)){
    header('Location: index.php');
    exit;
}

$currentTeamCreator = $team['creator'];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <title>Team aanpassen</title>
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
<div class="home-main-t">
    <div class="center">
        <div class="team-content">
            <?php
                if ($user['admin'] == 1) {
                    echo "<h2>Team aanpassen: {$team['name']}</h2>";
                    echo "<form action='teamController.php' method='post'>";
                    echo "<input type='hidden' name='type' value='edit'>";
                    echo "<input type='hidden' name='id' value='{$team['id']}'>";
                    echo "<input class='l-type-text-last' type='text' id='name' name='name' value='{$team['name']}'>";
                    echo "<input class='form-button' type='submit' value='Team aanpassen'>";
                    echo "</form>";
                    echo "<form action='teamController.php' method='post'>";
                    echo "<input type='hidden' name='type' value='delete'>";
                    echo "<input type='hidden' name='id' value='{$team['id']}'>";
                    echo "<input class='form-button-d' type='submit' value='Verwijder team'>";
                    echo "</form>";
                    $players = "";
                    $allPlayersCurrentTeam = explode(",", $team['players']);
                    $allPlayersCurrentTeamCount = count($allPlayersCurrentTeam);
                    for ($x = 0; $x < $allPlayersCurrentTeamCount; $x++){
                    $currentUser = $allPlayersCurrentTeam[$x];
                        foreach ($users as $key => $val) {
                            if ($val['id'] == $currentUser) {
                            $players = $players . $val['username'] . ", ";
                            }
                        }
                    }
                    echo "<p>Spelers: {$players}</p>";
                    for ($i = 0; $i < $countUsers; $i++){
                        $currentUser = $users[$i];
                        if ($currentUser['teamid'] == 0 && $currentUser['admin'] == 0) {
                        echo "<form action='teamController.php' method='post'>";
                            echo "<input type='hidden' name='type' value='addPlayer'>";
                            echo "<input type='hidden' name='teamID' value='{$team['id']}'>";
                            echo "<input type='hidden' name='playerID' value='{$currentUser['id']}'>";
                            echo "<input class='form-button-s' type='submit' value='Speler toevoegen: {$currentUser['username']}'>";
                            echo "</form>";
                        }
                    }
                }
                else {
                    if ($currentTeamCreator == $user['id']) {
                        echo "<h2>Team aanpassen: {$team['name']}</h2>";
                        echo "<form action='teamController.php' method='post'>";
                        echo "<input type='hidden' name='type' value='edit'>";
                        echo "<input type='hidden' name='id' value='{$team['id']}'>";
                        echo "<input class='l-type-text-last' type='text' id='name' name='name' value='{$team['name']}'>";
                        echo "<input class='form-button' type='submit' value='Team aanpassen'>";
                        echo "</form>";
                        $players = "";
                        $allPlayersCurrentTeam = explode(",", $team['players']);
                        $allPlayersCurrentTeamCount = count($allPlayersCurrentTeam);
                        for ($x = 0; $x < $allPlayersCurrentTeamCount; $x++){
                            $currentUser = $allPlayersCurrentTeam[$x];
                            foreach ($users as $key => $val) {
                                if ($val['id'] == $currentUser) {
                                $players = $players . $val['username'] . ", ";
                                }
                            }
                        }
                        echo "<p>Spelers: {$players}</p>";
                        for ($i = 0; $i < $countUsers; $i++){
                            $currentUser = $users[$i];
                            if ($currentUser['teamid'] == 0 && $currentUser['admin'] == 0) {
                                echo "<form action='teamController.php' method='post'>";
                                echo "<input type='hidden' name='type' value='addPlayer'>";
                                echo "<input type='hidden' name='teamID' value='{$team['id']}'>";
                                echo "<input type='hidden' name='playerID' value='{$currentUser['id']}'>";
                                echo "<input class='form-button-s' type='submit' value='Voeg speler toe: {$currentUser['username']}'>";
                                echo "</form>";
                            }
                        }
                    }
                    else {
                        echo "<p>You cannot edit this team!</p>";
                        echo "<a href='team-overview.php'>Go back</a>";
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
</html>
