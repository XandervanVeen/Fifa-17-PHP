<?php
session_start();
require 'style.php';
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
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form action="loginController.php" method="post">
        <input type="hidden" name="type" value="login">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required placeholder="email@gmail.com"><br>
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required placeholder="Password"><br>
        <br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
