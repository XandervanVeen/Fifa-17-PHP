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
    // Retrieve schedule
    $sql = "SELECT * FROM schedule";
    $query = $db->query($sql);
    $schedule = $query->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($schedule)){
        header('Location: index.php');
    }
}
else {
    header("Location: index.php");
}
$sql = "SELECT * FROM referee";
$query = $db->query($sql);
$referees = $query->fetchAll(PDO::FETCH_ASSOC);
$refereesCount = count($referees);
for ($i = 0; $i < $refereesCount; $i++){
    $allReferees[$i] = $referees[$i]['name'];
}
if (!empty($allReferees)) {
    sort($allReferees);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add referee</title>
</head>
<style>
    .referees tr th {
        border: black 1px solid;
        padding: 5px;
    }
</style>
<body>
    <a href="index.php">Go back</a>
    <h1>Add referee</h1>
    <form action="refereeController.php" method="post">
        <input type="hidden" name="type" value="add">
        <label for="refereeName">Referee name</label>
        <input type="text" id="refereeName" name="refereeName" placeholder="Referee name"><br>
        <br>
        <input type="submit" value="Add referee">
    </form>
    <h2>All referees:</h2>
    <table class="referees">
        <tr>
            <th style="width: 200px;">Referee name</th>
            <th style="width: 200px;">Delete referee</th>
        </tr>
            <?php
                for ($i = 0; $i < $refereesCount; $i++){
                    echo "<tr><th>{$allReferees[$i]}</th>";
                    echo "<th>";
                        echo "<form action='refereeController.php' method='post'>";
                        echo "<input type='hidden' name='type' value='delete'>";
                        foreach ($referees as $key => $val) {
                            if ($val['name'] == $allReferees[$i]) {
                                $currentReferee = $val;
                            }
                        }
                        echo "<input type='hidden' name='id' value='{$currentReferee['id']}'>";
                        echo "<input type='submit' value='delete'>";
                        echo "</form>";
                    echo "</th>";
                    echo "</tr>";
                }
            ?>
    </table>
</body>
</html>