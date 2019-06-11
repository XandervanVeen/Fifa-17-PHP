<?php

require 'config.php';
// require 'icon.html';
// Initialize the session
session_start();

// Check if the user is already logged in, if not redirect him to the index
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
$id = $user['id'];
// Retrieve schedule
$sql = "SELECT * FROM schedule";
$query = $db->query($sql);
$schedule = $query->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM teams";
$query = $db->query($sql);
$teams = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <title>Logged In</title>
</head>
<body>
    <div class="home-header">
        <a class="home-logo" href="index.php">
            <h1>FIFA 17</h1>
            <img src="img/football.jpg" alt="logo-img">
        </a>
        <nav>
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
            <div class="dashboard-content">
                <h2>Dashboard:</h2>
                <div class="nav-dashboard">
                    <div>
                        <a href="team-overview.php">Alle teams</a>
                        <?php
                        if (!empty($schedule)){
                            echo "<a href='schedule-overview.php'>Schema</a>";
                        }
                        if ($user['admin'] == 1){
                            if (empty($schedule)){
                                echo "<a href='preSchedule.php'>Schema creëren</a>";
                                echo "<a href='addField.php'>Velden</a>";
                                echo "<a href='addReferee.php'>Scheidsrechters</a>";
                            }
                        }
                        if (empty($schedule) && $user['teamid'] == 0 && $user['admin'] == 0){
                            echo "<a href='addTeam.php'>Nieuw team aanmaken</a>";
                        }
                        ?>
                    </div>
                    <?php
                    // Point overview
                    if (!empty($schedule)){
                    echo "<table>
                        <tr class='even-tr'>
                            <th class='th-30'></th>
                            <th class='th-200'>Team naam</th>
                            <th class='th-200'>Punten</th>
                        </tr>";
                        function cmp($a, $b){
                            return strcmp($b['points'], $a['points']);
                        }
                        usort($teams, "cmp");
                        array_reverse($teams);
                        $oddOrEven = 1;
                        for($i = 0; $i < count($teams); $i++){
                            if($oddOrEven % 2 == 0){
                                // Even
                                echo '<tr class="even-tr">';
                            }
                            else {
                                // Odd
                                echo '<tr class="odd-tr">';
                            }
                            $oddOrEven++;
                            $teamNumer = $i + 1;
                            echo "<th>{$teamNumer}</th>";
                            echo "<th>{$teams[$i]['name']}</th>";
                            echo "<th>{$teams[$i]['points']}</th>";
                            echo "</tr>";
                        }
                    }
                    ?>
                    </table>
                </div>
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
