<?php
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbname = 'fifa-17';

$db = new PDO(
    "mysql:host=$dbHost;dbname=$dbname",
    $dbUser,
    $dbPass
);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>