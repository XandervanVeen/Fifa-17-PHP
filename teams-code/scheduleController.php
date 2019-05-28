<?php
require 'config.php';
require 'style.php';
session_start();
if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
    header('Location: index.php');
    exit;
};
$sql = "SELECT * FROM referee";
$query = $db->query($sql);
$referees = $query->fetchAll(PDO::FETCH_ASSOC);
$refereeCount = count($referees);
if ($refereeCount == 0){
    echo "<p>Er is nog geen scheidsrechter toegevoegd!</p>";
    echo "<br><a href='addReferee.php'>Scheidsrechter toevoegen</a>";
    exit;
}
else {
    $refereeCount = count($referees);
    for ($i = 0; $i < $refereeCount; $i++){
        $allReferees[$i] = $referees[$i]['id'];
    }
    sort($allReferees);
}
$sql = "SELECT * FROM teams";
$query = $db->query($sql);
$teams = $query->fetchAll(PDO::FETCH_ASSOC);
$sql = "SELECT * FROM fields";
$query = $db->query($sql);
$fields = $query->fetchAll(PDO::FETCH_ASSOC);
$fieldsCount = count($fields);
if ($fieldsCount == 0){
    $allFields[0] = 1;
}
else {
    $fieldsCount = count($fields);
    for ($i = 0; $i < $fieldsCount; $i++){
        $allFields[$i] = $fields[$i]['fieldNumber'];
    }
    sort($allFields);
}
if ($_POST['type'] === 'generate'){
    if (count($teams) <= 1) {
        echo "There are not enough teams to generate a schedule";
        exit;
    }
    if (isset($_POST['matchTime']) && !empty($_POST['matchTime'])){
        $matchTime = htmlentities(trim($_POST['matchTime']));
        if (!is_numeric($matchTime)){
            echo "<p>Match time has to be a number!</p>";
            echo "<br><a href='preSchedule.php'>Retry</a>";
            exit;
        }
    }
    else {
        echo "niks ingevuld bij matchTime";
        exit;
    }
    if (isset($_POST['breakTime']) && !empty($_POST['breakTime'])){
        $breakTime = htmlentities(trim($_POST['breakTime']));
        if (!is_numeric($breakTime)){
            echo "<p>Break time has to be a number!</p>";
            echo "<br><a href='preSchedule.php'>Retry</a>";
            exit;
        }
    }
    else {
        echo "niks ingevuld bij breakTime";
        exit;
    }
    if (isset($_POST['restTimeCheck']) && !empty($_POST['restTimeCheck'])){
        if (isset($_POST['restTime']) && !empty($_POST['restTime'])) {
            $restTime = htmlentities(trim($_POST['restTime']));
            if (!is_numeric($restTime)){
                echo "<p>Rest time has to be a number!</p>";
                echo "<br><a href='preSchedule.php'>Retry</a>";
                exit;
            }
        }
        else {
            echo "niks ingevuld bij restTime";
            exit;
        }
    }
    else {
        $restTime = 0;
    }
    // Retrieve all teams
    $sql = "SELECT * FROM teams";
    $query = $db->query($sql);
    $teams = $query->fetchAll(PDO::FETCH_ASSOC);
    $shedule1 = array();
    $shedule2 = array();
    $teamsCount = count($teams);
    for ($i = 0; $i < $teamsCount; $i++){
        $allTeams[$i] = $teams[$i]['id'];
    }
    $allTeamsCount = count($allTeams);
    for ($i = 0; $i < $allTeamsCount; $i++){
        $team1 = array_shift($allTeams);
        $currentTeamsCount = count($allTeams);
        for ($x = 0; $x < $currentTeamsCount; $x++){
            array_push($shedule1,$team1);
            array_push($shedule2,$allTeams[$x]);
        }
    }
    $shedule1Count = count($shedule1);
    for ($i = 0, $x = -1, $c = -1; $i < $shedule1Count; $i++){
        if ($fieldsCount - 1 <= $x) {
            $x = 0;
        }
        else {
            $x++;
        }
        if ($refereeCount - 1 <= $c) {
            $c = 0;
        }
        else {
            $c++;
        }
        $currentReferee = $allReferees[$c];
        $currentField = $allFields[$x];
        $sql = "INSERT INTO schedule (team1, team2, matchtime, breaktime, resttime, field, referee, team1score, team2score)
        VALUES ( :team1, :team2, :matchtime, :breaktime, :resttime, :field, :referee, :team1score, :team2score)";
        $prepare = $db->prepare($sql);
        $prepare->execute([
            ':team1'      => $shedule1[$i],
            ':team2'      => $shedule2[$i],
            ':matchtime'  => $matchTime,
            ':breaktime'  => $breakTime,
            ':resttime'   => $restTime,
            ':field'      => $currentField,
            ':referee'    => $currentReferee,
            ':team1score' => 0,
            ':team2score' => 0
        ]);
    }
    header ('Location: schedule-overview.php');
}
if ($_POST['type'] === 'scoreInput'){
    $id = $_POST['id'];
    $team1score = trim(htmlentities($_POST['team1score']));
    $team2score = trim(htmlentities($_POST['team2score']));
    if (empty($team1score) || $team1score < 0){
        $team1score = 0;
    }
    if (empty($team2score) || $team2score < 0){
        $team2score = 0;
    }
    if (!is_numeric($team1score) || !is_numeric($team2score)){
        echo "<p>Team score has to be a number!</p>";
        echo "<br><a href='scoreInput.php?id=$id'>Retry</a>";
        exit;
    }
    if ($team1score > 99 || $team2score > 99){
        echo "<p>Team score cannot be higher than 99!</p>";
        echo "<br><a href='scoreInput.php?id=$id'>Retry</a>";
        exit;
    }
    $sql = "UPDATE schedule SET 
        team1score   = :team1score,
        team2score   = :team2score
        WHERE id = :id";
    $prepare= $db->prepare($sql);
    $prepare->execute([
        ':team1score'  => $team1score,
        ':team2score'  => $team2score,
        ':id'          => $id
    ]);
    header('Location: schedule-overview.php');
}
if ($_POST['type'] === 'delete'){
    $sql = "DELETE FROM schedule";
    $query = $db->query($sql);
    $sql = "TRUNCATE schedule";
    $query = $db->query($sql);
    header('Location: schedule-overview.php');
}
?>