<?php
require 'config.php';
if (isset( $_GET['id'] ) && !empty( $_GET['id'])){
    $sql = "SELECT * FROM teams WHERE id = :id";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':id' => $_GET['id']
    ]);
    $team = $prepare->fetch(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($team);
}
else {
    $sql = "SELECT * FROM teams";
    $query = $db->query($sql);
    $teams = $query->fetchAll(PDO::FETCH_ASSOC);
    $teamNames['names'] = array();
    $length = count($teams) - 1;
    for($i=0;$i<=$length;$i++){
        $teamNames['names'][] = $teams[$i]['name'];
    }
    header('Content-Type: application/json');
    echo json_encode($teamNames);
}
?>
