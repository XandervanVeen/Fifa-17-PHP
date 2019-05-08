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
$email = trim($_POST['email']);
if (isset($_POST['username']) && !empty($_POST['username'])){
    $username = trim($_POST['username']);
}
$password = trim($_POST['password']);

// The following runs if the post type is register
if ($_POST['type'] === 'register') {
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
            echo 'user has been logged in!';
            session_start();

            // Store data in session variables
            $_SESSION["loggedin"] = true;

            // TODO: Werken met id inplaats van email
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
            echo 'Failed to log in!';
        }
    }
}
