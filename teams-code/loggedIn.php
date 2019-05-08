<?php
require 'config.php';
require 'style.php';
// Initialize the session
session_start();

// Check if the user is already logged in, if not redirect him to the index
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
}
else {
    header("Location: index.php");
}
$sql = "SELECT * FROM users WHERE id = :id";
$prepare = $db->prepare($sql);
$prepare->execute([
    ':id' => $_SESSION['id']
]);
$user = $prepare->fetch(PDO::FETCH_ASSOC);
echo 'Welcome: ' . $user['email'];
echo '<br>';
$id = $user['id'];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Logged In</title>
</head>
<body>
    <a href="logout.php">Logout</a>
    <br>
    <a href="team-overview.php">All teams</a>
    <form action="addTeam.php" method="post">
        <input type="hidden" name="type" value="add">
        <input type="hidden" name="id" value="<?=$id?>">
        <input type="submit" value="Create new team">
    </form>
    <?php
    if ($user['admin'] == 1){
        echo '<h2>Welcome! you have logged in as an admin!</h2>';
        echo '<p>Admin controls:</p>';
    }
    ?>
</body>
</html>
