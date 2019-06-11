<?php
require 'config.php';
require 'icon.html';
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header('Location: loggedIn.php');
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
    <title>Registreer</title>
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
            <div class="register-content">
                <h2>Nieuw account</h2>
                <form action="loginController.php" method="post">
                    <input type="hidden" name="type" value="register">
                    <input class="r-type-text" type="email" id="email" name="email" required placeholder="Email">
                    <input class="r-type-text" type="text" id="username" name="username" required placeholder="Gebruikersnaam">
                    <input class="r-type-text-last" type="password" id="password" required name="password" placeholder="Wachtwoord">
                    <input class="form-button" type="submit" value="Registreer">
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
