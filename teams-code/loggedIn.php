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
// Retrieve schedule
$sql = "SELECT * FROM schedule";
$query = $db->query($sql);
$schedule = $query->fetchAll(PDO::FETCH_ASSOC);
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
    <?php
    if (!empty($schedule)){
        echo "<br><a href='schedule-overview.php'>Schedule</a>";
    }
    if ($user['admin'] == 1){
        if (empty($schedule)){
            echo "<br><a href='preSchedule.php'>Create schedule</a>";
            echo "<br><a href='addField.php'>Fields</a>";
            echo "<br><a href='addReferee.php'>Referee</a>";
        }
    }
    if (empty($schedule) && $user['teamid'] == 0){
        echo "<form action='addTeam.php' method='post'>
        <input type='hidden' name='type' value='add'>
        <input type='hidden' name='id' value='<?=$id?>'>
        <input type='submit' value='Create new team'>
        </form>";
    }
    ?>
</body>
</html>
