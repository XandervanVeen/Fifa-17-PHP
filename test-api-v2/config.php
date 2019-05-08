<?php
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbname = 'fifa-teams';

$db = new PDO(
    "mysql:host=$dbHost;dbname=$dbname",
    $dbUser,
    $dbPass
);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>