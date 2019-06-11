<?php
require 'config.php';
require 'icon.html';
session_start();
// Retrieve all teams
$sql = "SELECT * FROM teams";
$query = $db->query($sql);
$teams = $query->fetchAll(PDO::FETCH_ASSOC);

// Retrieve all users
$sql = "SELECT * FROM users";
$query = $db->query($sql);
$users = $query->fetchAll(PDO::FETCH_ASSOC);

// Retrieve all from schedule
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
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <title>Alle teams</title>
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
            <div class="home-content-t">
                <h2>Alle teams:</h2>
                <table class="teams">
                    <tr class="even-tr">
                        <th class='th-200'>Team naam</th>
                        <th class='th-200'>Spelers</th>
                        <th class='th-200'>Maker</th>
                        <?php
                            if ($id != null && $user['teamid'] == 0 && $user['admin'] == 0){
                                echo "<th class='th-200'>Deelnemen</th>";
                            }
                        ?>
                    </tr>
                    <?php
                    $totalTeams = count($teams);
                    $oddOrEven = 1;
                    for ($i = 0; $i < $totalTeams; $i++){
                        $currentTeam = $teams[$i];
                        $creator = $currentTeam['creator'];
                        foreach ($users as $key => $val) {
                            if ($val['id'] == $creator) {
                                $creatorDetail = $val;
                            }
                        }
                        if($oddOrEven % 2 == 0){
                            // Even
                            echo '<tr class="even-tr">';
                        }
                        else {
                            // Odd
                            echo '<tr class="odd-tr">';
                        }
                        $oddOrEven++;
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
                        if ($id != null && $user['teamid'] == 0 && $user['admin'] == 0){
                            echo "<th><form action='teamController.php' method='post'>";
                            echo "<input type='hidden' name='type' value='addPlayerSolo'>";
                            echo "<input type='hidden' name='id' value='{$currentTeam['id']}'>";
                            echo "<input type='submit' value='Deelnemen in team'>";
                            echo "</form></th>";
                        }
                        echo '</tr>';
                    }
                    ?>
                </table>
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
