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
if ($user['admin'] == 1) {
    echo "<h1>Edit team: {$team['name']}</h1>";
    echo "<form action='teamController.php' method='post'>";
    echo "<input type='hidden' name='type' value='edit'>";
    echo "<input type='hidden' name='id' value='{$team['id']}'>";
    echo "<label for='name'>Team name</label>";
    echo "<input type='text' id='name' name='name' value='{$team['name']}'><br>";
    echo "<input type='submit' value='Edit team'>";
    echo "</form>";
    echo "<form action='teamController.php' method='post'>";
    echo "<input type='hidden' name='type' value='delete'>";
    echo "<input type='hidden' name='id' value='{$team['id']}'>";
    echo "<input type='submit' value='delete'>";
    echo "</form>";
    echo "<br>";
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
    echo "<p>Players: {$players}</p><br>";
    for ($i = 0; $i < $countUsers; $i++){
        $currentUser = $users[$i];
        if ($currentUser['teamid'] == 0 && $currentUser['admin'] == 0) {
            echo "<form action='teamController.php' method='post'>";
            echo "<input type='hidden' name='type' value='addPlayer'>";
            echo "<input type='hidden' name='teamID' value='{$team['id']}'>";
            echo "<input type='hidden' name='playerID' value='{$currentUser['id']}'>";
            echo "<input type='submit' value='Add Player: {$currentUser['username']}'>";
            echo "</form>";
        }
    }
    echo "<br>";
}
else {
    if ($currentTeamCreator == $user['id'])
    {
        echo "<h1>Edit team: {$team['name']}</h1>";
        echo "<form action='teamController.php' method='post'>";
        echo "<input type='hidden' name='type' value='edit'>";
        echo "<input type='hidden' name='id' value='{$team['id']}'>";
        echo "<label for='name'>Team name</label>";
        echo "<input type='text' id='name' name='name' value='{$team['name']}'><br>";
        echo "<br>";
        echo "<input type='submit' value='Edit team'>";
        echo "</form>";
        echo "<br>";
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
        echo "<p>Players: {$players}</p><br>";
        for ($i = 0; $i < $countUsers; $i++){
            $currentUser = $users[$i];
            if ($currentUser['teamid'] == 0 && $currentUser['admin'] == 0) {
                echo "<form action='teamController.php' method='post'>";
                echo "<input type='hidden' name='type' value='addPlayer'>";
                echo "<input type='hidden' name='teamID' value='{$team['id']}'>";
                echo "<input type='hidden' name='playerID' value='{$currentUser['id']}'>";
                echo "<input type='submit' value='Add Player: {$currentUser['username']}'>";
                echo "</form>";
            }
        }
        echo "<br>";
    }
    else
    {
        echo "You cannot edit this team!<br>";
        echo "<a href='team-overview.php'>Go back</a>";
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
    <title>Edit team</title>
</head>
<style>
    p {
        line-height: 1;
        padding: 0px;
        margin: 0px;
        color: #666666;
    }
</style>
<body>

</body>
</html>
