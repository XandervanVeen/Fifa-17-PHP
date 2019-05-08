<?php
require 'style.php';
$id = $_POST['id'];
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
        <p>Schrijf de spelers in het team op zoals: Dirk,Jan,Michiel etc</p>
        <label for="players">Players</label>
        <input type="text" id="players" name="players" placeholder="Dirk,Jan,Michiel etc"><br>
        <br>
        <input type="submit" value="Add team">
    </form>
</body>
</html>
