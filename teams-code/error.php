<?php
session_start();
//require 'icon.html';
if (isset($_GET["error"]) && $_GET["error"] === true){
    header("Location: index.php");
}
else {
    $error = $_GET['error'];
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
    <title>Home</title>
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
            <h2>Oeps er is iets fout gegaan!</h2>
            <?php
                echo "<h4>{$error}</h4>";
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
