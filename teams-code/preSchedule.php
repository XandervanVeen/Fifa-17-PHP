<?php
require 'config.php';
require 'style.php';
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    $sql = "SELECT * FROM users WHERE id = :id";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':id' => $_SESSION['id']
    ]);
    $user = $prepare->fetch(PDO::FETCH_ASSOC);
    if ($user['admin'] == 0) {
        header("Location: index.php");
    }
}
else {
    header("Location: index.php");
}
$sql = "SELECT * FROM schedule";
$query = $db->query($sql);
$schedule = $query->fetchAll(PDO::FETCH_ASSOC);
if (!empty($schedule)) {
    header("Location: index.php");
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>preShedule</title>
</head>
<body>
    <form action="scheduleController.php" method="post">
        <input type="hidden" name="type" value="generate">
        <label for="matchTime">Hoe lang gaat elke wedstrijd duren?</label>
        <input type="text" id="matchTime" name="matchTime" required placeholder="Schrijf op in minuten"><br>
        <label for="breakTime">Hoe lang gaat de pauze tussen elke wedstrijd duren?</label>
        <input type="text" id="breakTime" name="breakTime" required placeholder="Schrijf op in minuten"><br>
        <label for="">Komt er rust tijd middenin de wedstrijd?</label>
        <input type="checkbox" id="restTimeCheck" name="restTimeCheck" style="float: left; margin-top: 5px;>">
        <label for="restTime">Zo ja, hoelang duurt de rust tijd dan?</label>
        <input type="text" id="restTime" name="restTime" placeholder="Schrijf op in minuten"><br>
        <br>
        <input type="submit" value="Genereer wedstrijd">
    </form>
</body>
</html>
