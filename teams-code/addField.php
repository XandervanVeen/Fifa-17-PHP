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
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <title>Veld toevoegen</title>
</head>
<body>
    <div class="home-header">
        <a class="home-logo" href="index.php">
            <h1>FIFA 17</h1>
            <img src="img/football.jpg" alt="logo-img">
        </a>
        <nav>
            <a class="return-button" href="index.php"><img src="img/house.png" alt="house-img"><p>Ga terug</p></a>
            <?php
            if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
                echo "<a href='logout.php'>Uitloggen</a>";
            }
            else {
                echo "<a href='login.php'>Login</a>";
                echo "<a href='register.php'>Registreer</a>";
            }
            ?>
        </nav>
    </div>
    <div class="home-main-f">
        <div class="center">
            <div class="field-content">
                <h2>Veld toevoegen</h2>
                <form action="fieldController.php" method="post">
                    <input type="hidden" name="type" value="add">
                    <input class="l-type-text" type="text" id="fieldNumber" name="fieldNumber" placeholder="Veld nummer">
                    <input class="form-button" type="submit" value="Veld toevoegen">
                </form>
                <h2>Alle velden:</h2>
                <table class="fields">
                    <tr>
                        <th style="width: 200px;">Veld nummer</th>
                        <th style="width: 200px;">Verwijderen</th>
                    </tr>
                        <?php
                        $oddOrEven = 0;
                            for ($i = 0; $i < $fieldsCount; $i++){
                                if($oddOrEven % 2 == 0){
                                    // Even
                                    echo '<tr class="even-tr">';
                                }
                                else {
                                    // Odd
                                    echo '<tr class="odd-tr">';
                                }
                                $oddOrEven++;
                                echo "<th>{$allFields[$i]}</th>";
                                echo "<th>";
                                    echo "<form action='fieldController.php' method='post'>";
                                    echo "<input type='hidden' name='type' value='delete'>";
                                    foreach ($fields as $key => $val) {
                                        if ($val['fieldNumber'] == $allFields[$i]) {
                                            $currentField = $val;
                                        }
                                    }
                                    echo "<input type='hidden' name='id' value='{$currentField['id']}'>";
                                    echo "<input type='submit' value='Verwijder veld'>";
                                    echo "</form>";
                                echo "</th>";
                                echo "</tr>";
                            }
                        ?>
                </table>
            </div>
        </div>
    </div>
    <div class="home-footer">
        <p>Telefoon: 0645871236</p>
        <p>Adres: Terheijdenseweg 350, 4826 AA Breda</p>
        <p>Email: radiuscollege@rocwb.nl</p>
    </div>
</body>
</html>