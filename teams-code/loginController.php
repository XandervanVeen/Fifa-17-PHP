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
    echo "niks ingevuld bij email";
    exit;
}
if (isset($_POST['password']) && !empty($_POST['password'])){
    $password = htmlentities(trim($_POST['password']));
}
else {
    echo "niks ingevuld bij password";
    exit;
}

// The following retrieves all the emails from the database to check if they already exist
$stmt = $db->prepare('SELECT COUNT(email) AS EmailCount FROM users WHERE email = :email');
$stmt->execute(array('email' => $_POST['email']));
$resultpassword = $stmt->fetch(PDO::FETCH_ASSOC);

// The following runs if the post type is register
if ($_POST['type'] === 'register') {
    if ($resultpassword['EmailCount'] == 1){
        echo "<p>That email is already in use!</p>";
        echo "<a href='register.php'>Go back</a>";
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<p>Invalid email address!</p>';
        echo '<a href="register.php">Go back</a>';
        exit;
    }
    if (strlen($email) > 128){
        echo "<p>Email is too long ( Maximal is 128 characters )</p>";
        echo '<a href="register.php">Go back</a>';
        exit;
    }
    if (isset($_POST['username']) && !empty($_POST['username'])){
        $username = htmlentities(trim($_POST['username']));
    }
    else {
        echo "<p>niks ingevuld bij username</p>";
        exit;
    }
    if (strlen($password) < 7){
        echo "<p>Password is too short ( Minimal is 7 characters )</p>";
        echo '<a href="register.php">Go back</a>';
        exit;
    }
    if (!preg_match("#[A-Z]+#", $password)) {
        echo '<p>Password needs atleast 1 capital letter</p>';
        echo '<a href="register.php">Go back</a>';
        exit;
    }
    if (!preg_match("#[0-9]+#", $password)) {
        echo '<p>Password needs atleast 1 number</p>';
        echo '<a href="register.php">Go back</a>';
        exit;
    }
    if (strlen($username) > 64){
        echo "<p>Username is too long ( Maximal is 64 characters )</p>";
        echo '<a href="register.php">Go back</a>';
        exit;
    }
    // Retrieve all users
    $sql = "SELECT * FROM users";
    $query = $db->query($sql);
    $users = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach ($users as $key => $val) {
        if (strtolower($val['username']) == strtolower($username)) {
            echo "<p>That username is already in use</p>";
            echo '<a href="register.php">Go back</a>';
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
            echo 'Failed to log in! (password is incorrect)';
            echo '<br><a href="index.php">Go back</a>';
            exit;
        }
    }
    else {
        echo 'Failed to log in! (email was not found)';
        echo '<br><a href="index.php">Go back</a>';
        exit;
    }
}
