<?php
require 'config.php';
require 'style.php';
session_start();

// Retrieve current session user
$sql = "SELECT * FROM users WHERE id = :id";
$prepare = $db->prepare($sql);
$prepare->execute([
    ':id' => $_SESSION['id']
]);
$user = $prepare->fetch(PDO::FETCH_ASSOC);

// Retrieve team where creator is current user
$sql = "SELECT * FROM teams WHERE id = :id";
$prepare = $db->prepare($sql);
$prepare->execute([
    ':id' => $_GET['id']
]);
$team = $prepare->fetch(PDO::FETCH_ASSOC);

$currentTeamCreator = $team['creator'];
if ($user['admin'] == 1) {
    echo "<h1>Edit team: {$team['name']}</h1>";
    echo "<form action='teamController.php' method='post'>";
    echo "<input type='hidden' name='type' value='edit'>";
    echo "<input type='hidden' name='id' value='{$team['id']}'>";
    echo "<label for='name'>Team name</label>";
    echo "<input type='text' id='name' name='name' value='{$team['name']}'><br>";
    echo "<label for='players'>Players</label>";
    echo "<input type='text' id='players' name='players' value='{$team['players']}'><br>";
    echo "<p>Schrijf de spelers in het team op zoals: Dirk,Jan,Michiel etc</p>";
    echo "<br>";
    echo "<input type='submit' value='Edit team'>";
    echo "</form>";
    echo "<form action='teamController.php' method='post'>";
    echo "<input type='hidden' name='type' value='delete'>";
    echo "<input type='hidden' name='id' value='{$team['id']}'>";
    echo "<input type='submit' value='delete'>";
    echo "</form>";
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
        echo "<label for='players'>Players</label>";
        echo "<input type='text' id='players' name='players' value='{$team['players']}'><br>";
        echo "<p>Schrijf de spelers in het team op zoals: Dirk,Jan,Michiel etc</p>";
        echo "<br>";
        echo "<input type='submit' value='Edit team'>";
        echo "</form>";
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
