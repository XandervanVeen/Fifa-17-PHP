<?php
require 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 'On');
if (isset( $_GET['token'] ) && !empty( $_GET['token'])){
    if ($_GET['token'] == 647382618) {
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
        else if (isset( $_GET['schedule'] ) && !empty( $_GET['schedule'])){
            $sql = "SELECT * FROM schedule";
            $query = $db->query($sql);
            $schedule = $query->fetchAll(PDO::FETCH_ASSOC);
            $length = count($schedule);
            for ($i = 0; $i < $length; $i++){
                $team1Id = $schedule[$i]['team1'];
                $team2Id = $schedule[$i]['team2'];
                $sql = "SELECT * FROM teams WHERE id = :id";
                $prepare = $db->prepare($sql);
                $prepare->execute([
                    ':id' => $team1Id
                ]);
                $team1 = $prepare->fetch(PDO::FETCH_ASSOC);
                $sql = "SELECT * FROM teams WHERE id = :id";
                $prepare = $db->prepare($sql);
                $prepare->execute([
                    ':id' => $team2Id
                ]);
                $team2 = $prepare->fetch(PDO::FETCH_ASSOC);
                $schedule[$i]['team1'] = $team1['name'];
                $schedule[$i]['team2'] = $team2['name'];
            }
            header('Content-Type: application/json');
            echo json_encode($schedule);
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
    }
    else {
        echo "Error: 401";
    }
}
else {
    echo "Error: 403";
}
?>
