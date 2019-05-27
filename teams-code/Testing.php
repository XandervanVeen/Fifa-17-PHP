<?php
require 'config.php';
require 'style.php';
session_start();
$sql = "SELECT * FROM teams";
$query = $db->query($sql);
$teams = $query->fetchAll(PDO::FETCH_ASSOC);
for ($i = 0; $i < count($teams); $i++) {
    $currentTeam = explode(",", $teams[$i]['players']);
    for ($x = 0; $x < count($currentTeam); $x++) {
        echo $currentTeam[$x] . "<br>";
    }
    echo "====================<br>";
}

$pizza  = "piece1,piece2,piece3,piece4,piece5,piece6";
$pizza = $pizza . ",piece7";
$pieces = explode(",", $pizza);
for ($i = 0; $i < count($pieces); $i++) {
    echo $pieces[$i] . "<br>";
}