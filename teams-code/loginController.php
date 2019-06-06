<?php
// Makes sure we have all the data needed to connect to the data base
require 'config.php';

// This checks if the user came to this page using a post request so that user cannot just
// visit this website
if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
    header('Location: index.php');
    exit;
};

// This sets the email, username and password so we can check if they are empty or not
if (isset($_POST['email']) && !empty($_POST['email'])){
    $email = htmlentities(trim($_POST['email']));
}
else {
    header('Location: error.php?error=Er is niks ingevuld bij email');
    exit;
}
if (isset($_POST['password']) && !empty($_POST['password'])){
    $password = htmlentities(trim($_POST['password']));
}
else {
    header('Location: error.php?error=Er is niks ingevuld bij wachtwoord');
    exit;
}

// The following retrieves all the emails from the database to check if they already exist
$stmt = $db->prepare('SELECT COUNT(email) AS EmailCount FROM users WHERE email = :email');
$stmt->execute(array('email' => $_POST['email']));
$resultpassword = $stmt->fetch(PDO::FETCH_ASSOC);

// The following runs if the post type is register
if ($_POST['type'] === 'register') {
    if ($resultpassword['EmailCount'] == 1){
        header('Location: error.php?error=Het ingevulde email adres bestaat al');
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: error.php?error=Het ingevulde email adres is ongeldig');
        exit;
    }
    if (strlen($email) > 128){
        header('Location: error.php?error=Het ingevulde email adres is te lang (Het maximale is 128 karakters lang)');
        exit;
    }
    if (isset($_POST['username']) && !empty($_POST['username'])){
        $username = htmlentities(trim($_POST['username']));
    }
    else {
        header('Location: error.php?error=Er is niks ingevuld bij gebruikers naam');
        exit;
    }
    if (strlen($password) < 7){
        header('Location: error.php?error=Het ingevulde wachtwoord is te kort (Het minimale is 7 karakters lang)');
        exit;
    }
    if (!preg_match("#[A-Z]+#", $password)) {
        header('Location: error.php?error=Het ingevulde wachtwoord moet 1 hoofdletter bevatten');
        exit;
    }

    if (!preg_match("#[0-9]+#", $password)) {
        header('Location: error.php?error=Het ingevulde wachtwoord moet 1 nummer bevatten');
        exit;
    }
    if (strlen($username) > 64){
        header('Location: error.php?error=Het ingevulde gebruikers naam is te lang (Het maximale is 64 karakters)');
        exit;
    }
    // Retrieve all users
    $sql = "SELECT * FROM users";
    $query = $db->query($sql);
    $users = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach ($users as $key => $val) {
        if (strtolower($val['username']) == strtolower($username)) {
            header('Location: error.php?error=Het ingevulde gebruikers naam bestaat al');
            exit;
        }
    }
    $password = password_hash($password, PASSWORD_BCRYPT);
    $admin = 0;
    $teamid = 0;
    $sql = "INSERT INTO users (email, password, username, teamid, admin)
    VALUES ( :email, :password, :username, :teamid, :admin )";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':email'      => $email,
        ':password'   => $password,
        ':username'   => $username,
        ':teamid'     => $teamid,
        ':admin'      => $admin
    ]);
    header('Location: index.php');
    exit;
}
// The following runs if the post type is login
if ( $_POST['type'] === 'login' ) {

    //Retrieve the table row for the given username.
    $sql = "SELECT id, email, password FROM users WHERE email = :email";

    //Prepare the statement.
    $stmt = $db->prepare($sql);

    //Bind the username value.
    $stmt->bindValue(':email', $email);

    //Execute the statement.
    $stmt->execute();

    //Fetch the table row.
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    //If we retrieved a relevant record.
    if($user !== false){
        //Compare the password attempt with the password we have stored.
        $validPassword = password_verify($password, $user['password']);
        if($validPassword){
            //All is good. Log the user in.

            // Start the session
            session_start();

            // Store data in session variables
            $_SESSION["loggedin"] = true;

            $sql = "SELECT * FROM users WHERE email = :email";
            $prepare = $db->prepare($sql);
            $prepare->execute([
                ':email' => $email
            ]);
            $user = $prepare->fetch(PDO::FETCH_ASSOC);
            $_SESSION["id"] = $user['id'];

            // Redirect user to welcome page
            header('Location: loggedIn.php');
        }
        else {
            header('Location: error.php?error=Kon niet inloggen (Wachtwoord is incorrect)');
            exit;
        }
    }
    else {
        header('Location: error.php?error=Kon niet inloggen (Email is niet gevonden)');
        exit;
    }
}
