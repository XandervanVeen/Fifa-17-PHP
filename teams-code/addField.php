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
$sql = "SELECT * FROM fields";
$query = $db->query($sql);
$fields = $query->fetchAll(PDO::FETCH_ASSOC);
$fieldsCount = count($fields);
for ($i = 0; $i < $fieldsCount; $i++){
    $allFields[$i] = $fields[$i]['fieldNumber'];
}
if (!empty($allFields)) {
    sort($allFields);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add field</title>
</head>
<style>
    .fields tr th {
        border: black 1px solid;
        padding: 5px;
    }
</style>
<body>
    <a href="index.php">Go back</a>
    <h1>Add field</h1>
    <form action="fieldController.php" method="post">
        <input type="hidden" name="type" value="add">
        <label for="fieldNumber">Field number</label>
        <input type="text" id="fieldNumber" name="fieldNumber" placeholder="Field number: 0, 1, 2"><br>
        <br>
        <input type="submit" value="Add field">
    </form>
    <h2>All fields:</h2>
    <table class="fields">
        <tr>
            <th style="width: 200px;">Field number</th>
            <th style="width: 200px;">Delete field</th>
        </tr>
            <?php
                for ($i = 0; $i < $fieldsCount; $i++){
                    echo "<tr><th>{$allFields[$i]}</th>";
                    echo "<th>";
                        echo "<form action='fieldController.php' method='post'>";
                        echo "<input type='hidden' name='type' value='delete'>";
                        foreach ($fields as $key => $val) {
                            if ($val['fieldNumber'] == $allFields[$i]) {
                                $currentField = $val;
                            }
                        }
                        echo "<input type='hidden' name='id' value='{$currentField['id']}'>";
                        echo "<input type='submit' value='delete'>";
                        echo "</form>";
                    echo "</th>";
                    echo "</tr>";
                }
            ?>
    </table>
</body>
</html>