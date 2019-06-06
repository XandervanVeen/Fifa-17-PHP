<?php
require 'config.php';
require 'style.php';
session_start();
$id = $_SESSION['id'];
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    // Retrieve schedule
    $sql = "SELECT * FROM schedule";
    $query = $db->query($sql);
    $schedule = $query->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($schedule)){
        header('Location: index.php');
    }
    $sql = "SELECT * FROM users WHERE id = :id";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':id' => $_SESSION['id']
    ]);
    $user = $prepare->fetch(PDO::FETCH_ASSOC);
    if ($user['teamid'] != 0){
        header('Location: index.php');
    }
}
else {
    header('Location: index.php');
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
    <title>Team aanmaken</title>
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
    <div class="home-main">
        <div class="center">
            <div class="team-content">
                <h2>Team aanmaken</h2>
                <form action="teamController.php" method="post">
                    <input type="hidden" name="type" value="add">
                    <input type="hidden" name="id" value="<?=$id?>">
                    <input class="l-type-text-last" type="text" id="name" name="name" placeholder="Team naam">
                    <input class="form-button" type="submit" value="Team toevoegen">
                </form>
                <p>Spelers kunnen toegevoegd worden als het team eenmaal is aangemaakt!</p>
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
