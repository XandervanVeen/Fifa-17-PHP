<?php
require 'config.php';
require 'style.php';
session_start();
// Retrieve all teams
$sql = "SELECT * FROM teams";
$query = $db->query($sql);
$teams = $query->fetchAll(PDO::FETCH_ASSOC);

// Retrieve all users
$sql = "SELECT * FROM users";
$query = $db->query($sql);
$users = $query->fetchAll(PDO::FETCH_ASSOC);

// Retrieve all schedule
$sql = "SELECT * FROM schedule";
$query = $db->query($sql);
$schedule = $query->fetchAll(PDO::FETCH_ASSOC);

// If user is logged in = retrieve user. If not = set id to null
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $sql = "SELECT * FROM users WHERE id = :id";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':id' => $_SESSION['id']
    ]);
    $user = $prepare->fetch(PDO::FETCH_ASSOC);
    $id = $user['id'];
}
else {
    $user['admin'] = 0;
    $id = null;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>All teams</title>
</head>
<style>
    .teams tr th {
        border: black 1px solid;
        padding: 10px;
    }
</style>
<body>
    <h2>All teams:</h2>
    <table class="teams">
        <tr>
            <th style="width: 200px;">Team name</th>
            <th style="width: 200px;">Players</th>
            <th style="width: 200px;">Creator</th>
            <?php
                if ($id != null && $user['teamid'] == 0){
                    echo "<th style='width: 200px;'>Participate</th>";
                }
            ?>
        </tr>
        <?php
        $totalTeams = count($teams);
        for ($i = 0; $i < $totalTeams; $i++){
            $currentTeam = $teams[$i];
            $creator = $currentTeam['creator'];
            foreach ($users as $key => $val) {
                if ($val['id'] == $creator) {
                    $creatorDetail = $val;
                }
            }
            echo '<tr>';
            if ($id == $creator || $user['admin'] == 1) {
                if (empty($schedule)) {
                    echo "<th style='font-weight: lighter;'><a href='editTeam.php?id={$teams[$i]['id']}'>" . $teams[$i]['name'] . "</a></th>";
                }
                else {
                    echo "<th style='font-weight: lighter;'>" . $currentTeam['name'] . "</th>";
                }
            }
            else {
                echo "<th style='font-weight: lighter;'>" . $currentTeam['name'] . "</th>";
            }
            $players = "";
            $allPlayersCurrentTeam = explode(",", $currentTeam['players']);
            $allPlayersCurrentTeamCount = count($allPlayersCurrentTeam);
            for ($x = 0; $x < $allPlayersCurrentTeamCount; $x++){
                $currentUser = $allPlayersCurrentTeam[$x];
                foreach ($users as $key => $val) {
                    if ($val['id'] == $currentUser) {
                        $players = $players . $val['username'] . ", ";
                    }
                }
            }
            echo '<th style="font-weight: lighter;">' . $players . '</th>';
            echo '<th style="font-weight: lighter;">' . $creatorDetail['username'] . '</th>';
            if ($id != null && $user['teamid'] == 0){
                echo "<th><form action='teamController.php' method='post'>";
                echo "<input type='hidden' name='type' value='addPlayerSolo'>";
                echo "<input type='hidden' name='id' value='{$currentTeam['id']}'>";
                echo "<input type='submit' value='Participate in team'>";
                echo "</form></th>";
            }
            echo '</tr>';
        }
        ?>
    </table>
    <a href="index.php">Go back</a>
</body>
</html>
