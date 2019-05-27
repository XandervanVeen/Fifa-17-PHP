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
    <title>Add team</title>
</head>
<body>
    <h1>Add team</h1>
    <form action="teamController.php" method="post">
        <input type="hidden" name="type" value="add">
        <input type="hidden" name="id" value="<?=$id?>">
        <label for="name">Team name</label>
        <input type="text" id="name" name="name" placeholder="Team name"><br>
        <p>Spelers kunnen toegevoegd worden als het team eenmaal is aangemaakt!</p>
        <br>
        <input type="submit" value="Add team">
    </form>
</body>
</html>
