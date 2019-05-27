<?php
require 'config.php';
require 'style.php';
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
    <title>Register</title>
</head>
<body>
    <h1>Create new account</h1>
    <form action="loginController.php" method="post">
        <input type="hidden" name="type" value="register">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required placeholder="email@gmail.com"><br>
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required placeholder="Username"><br>
        <label for="password">Password</label>
        <input type="password" id="password" required name="password" placeholder="Password"><br>
        <br>
        <input type="submit" value="Register">
    </form>
</body>
</html>
