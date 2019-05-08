<?php
require 'config.php';
$sql = "SELECT * FROM teams";
$query = $db->query($sql);
$teams = $query->fetchAll(PDO::FETCH_ASSOC);
if (isset( $_GET['id'] ) && !empty( $_GET['id'])){
    $id = $_GET['id'] - 1;
    $team = new stdClass;
    $team->name = "";
    $team->players = "";
    $team->id = "";
    $team->name = $teams[$id]['name'];
    $team->players = $teams[$id]['players'];
    $team->id = $teams[$id]['id'];
    header('Content-Type: application/json');
    echo json_encode($team);
}
else {
    $teamNames['names'] = array();
    $length = count($teams) - 1;
    for($i=0;$i<=$length;$i++){
        $teamNames['names'][] = $teams[$i]['name'];
    }
    header('Content-Type: application/json');
    echo json_encode($teamNames);
}
?>
