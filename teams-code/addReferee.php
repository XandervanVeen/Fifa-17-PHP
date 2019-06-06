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
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <title>Scheidsrechter toevoegen</title>
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
                <h2>Scheidsrechter toevoegen</h2>
                <form action="refereeController.php" method="post">
                    <input type="hidden" name="type" value="add">
                    <input class="l-type-text" type="text" id="refereeName" name="refereeName" placeholder="Scheidsrechter naam">
                    <input class="form-button" type="submit" value="Scheidsrechter toevoegen">
                </form>
                <h2>Alle scheidsrechters:</h2>
                <table class="referees">
                    <tr>
                        <th style="width: 200px;">Naam</th>
                        <th style="width: 200px;">Verwijder</th>
                    </tr>
                        <?php
                        $oddOrEven = 0;
                            for ($i = 0; $i < $refereesCount; $i++){
                                if($oddOrEven % 2 == 0){
                                    // Even
                                    echo '<tr class="even-tr">';
                                }
                                else {
                                    // Odd
                                    echo '<tr class="odd-tr">';
                                }
                                $oddOrEven++;
                                echo "<th>{$allReferees[$i]}</th>";
                                echo "<th>";
                                    echo "<form action='refereeController.php' method='post'>";
                                    echo "<input type='hidden' name='type' value='delete'>";
                                    foreach ($referees as $key => $val) {
                                        if ($val['name'] == $allReferees[$i]) {
                                            $currentReferee = $val;
                                        }
                                    }
                                    echo "<input type='hidden' name='id' value='{$currentReferee['id']}'>";
                                    echo "<input type='submit' value='Verwijder scheidsrechter'>";
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