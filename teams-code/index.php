<?php
require 'config.php';
require 'style.php';
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header('Location: loggedIn.php');
}
$sql = "SELECT * FROM schedule";
$query = $db->query($sql);
$schedule = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
</head>
<body>
    <h1>Welcome to the test login system!</h1>
    <a href="login.php">Login</a>
    <br>
    <a href="register.php">Register</a>
    <br>
    <a href="team-overview.php">All teams</a>
    <?php
    if (!empty($schedule)){
        echo "<br><a href='schedule-overview.php'>Schedule</a>";
    }
    ?>
</body>
</html>
