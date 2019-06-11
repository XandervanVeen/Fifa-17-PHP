<?php
require 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 'On');
//require 'style.php';
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
    header('Location: error.php?error=Er is nog geen scheidsrechter toegevoegd');
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
        header('Location: error.php?error=Er zijn niet genoeg teams om een schema te maken');
        exit;
    }
    if (isset($_POST['matchTime']) && !empty($_POST['matchTime'])){
        $matchTime = htmlentities(trim($_POST['matchTime']));
        if (!is_numeric($matchTime)){
            header('Location: error.php?error=Het ingevulde wedstrijd tijd moet een nummer zijn');
            exit;
        }
    }
    else {
        header('Location: error.php?error=Er is niks ingevuld bij wedstrijd tijd');
        exit;
    }
    if (isset($_POST['breakTime']) && !empty($_POST['breakTime'])){
        $breakTime = htmlentities(trim($_POST['breakTime']));
        if (!is_numeric($breakTime)){
            header('Location: error.php?error=Het ingevulde pauze tijd moet een nummer zijn');
            exit;
        }
    }
    else {
        header('Location: error.php?error=Er is niks ingevuld bij pauze tijd');
        exit;
    }
   
if (isset($_POST['restTime']) && !empty($_POST['restTime'])) {
            $restTime = htmlentities(trim($_POST['restTime']));
            if (!is_numeric($restTime)){
                header('Location: error.php?error=Het ingevulde rust tijd moet een nummer zijn');
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
        header('Location: error.php?error=Het ingevulde team score moet een nummer zijn');
        exit;
    }
    if ($team1score > 99 || $team2score > 99){
        header('Location: error.php?error=Het ingevulde team score mag niet hoger zijn dan 99');
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

    $sql = "SELECT * FROM schedule WHERE id = :id";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':id' => $id
    ]);
    $match = $prepare->fetch(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM teams WHERE id = :id";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':id' => $match['team1']
    ]);
    $team1 = $prepare->fetch(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM teams WHERE id = :id";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':id' => $match['team2']
    ]);
    $team2 = $prepare->fetch(PDO::FETCH_ASSOC);


    $hasBeenEdited = 1;
    $sql = "UPDATE schedule SET 
        hasBeenEdited   = :hasBeenEdited
        WHERE id = :id";
    $prepare= $db->prepare($sql);
    $prepare->execute([
        ':hasBeenEdited'  => $hasBeenEdited,
        ':id'          => $id
    ]);

    if ($team1score > $team2score ){
        $id = $match['team1'];
        $points = $team1['points'] + 3;
        $sql = "UPDATE teams SET 
        points   = :points
        WHERE id = :id";
        $prepare= $db->prepare($sql);
        $prepare->execute([
            ':points'       => $points,
            ':id'          => $id
        ]);
    }

    if ($team1score < $team2score ){
        $id = $match['team2'];
        $points = $team2['points'] + 3;
        $sql = "UPDATE teams SET 
        points   = :points
        WHERE id = :id";
        $prepare= $db->prepare($sql);
        $prepare->execute([
            ':points'       => $points,
            ':id'          => $id
        ]);
    }
    if ($team1score == $team2score ){
        $points1 = $team1['points'] + 1;
        $id1 = $match['team1'];
        $sql = "UPDATE teams SET 
        points   = :points
        WHERE id = :id";
        $prepare= $db->prepare($sql);
        $prepare->execute([
            ':points'       => $points1,
            ':id'           => $id1
        ]);

        $points2 = $team2['points'] + 1;
        $id2 = $match['team2'];
        $sql = "UPDATE teams SET 
        points   = :points
        WHERE id = :id";
        $prepare= $db->prepare($sql);
        $prepare->execute([
            ':points'       => $points2,
            ':id'           => $id2
        ]);
    }
    header('Location: schedule-overview.php');
}
if ($_POST['type'] === 'delete'){
    $sql = "DELETE FROM schedule";
    $query = $db->query($sql);
    $sql = "TRUNCATE schedule";
    $query = $db->query($sql);

    $points = 0;
    $sql = "UPDATE teams SET 
        points   = :points";
    $prepare= $db->prepare($sql);
    $prepare->execute([
        ':points'       => $points
    ]);
    header('Location: schedule-overview.php');
}
?>