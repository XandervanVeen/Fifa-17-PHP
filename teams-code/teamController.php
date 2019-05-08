<?php
require 'config.php';
$id = $_POST['id'];
$name = $_POST['name'];
$players = $_POST['players'];
// If the post type is add
if ($_POST['type'] === 'add') {
    $sql = "INSERT INTO teams (name, players, creator)
        VALUES ( :name, :players, :creator )";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':name' => $name,
        ':players' => $players,
        ':creator' => $id
    ]);
    header('Location: team-overview.php');
}
// If the post type is edit
if ($_POST['type'] === 'edit') {
    $sql = "UPDATE teams SET 
    name        = :name,
    players     = :players
    WHERE id = :id";
    $prepare= $db->prepare($sql);
    $prepare->execute([
        ':name'      => $_POST['name'],
        ':players'   => $_POST['players'],
        ':id'        => $_POST['id']
    ]);
    header("Location: team-overview.php");
    exit;
}
// If the post type is delete
if ($_POST['type'] === 'delete') {
    $id = $_POST['id'];
    $sql = "DELETE FROM teams WHERE id = :id";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':id' => $id
    ]);
    header("Location: team-overview.php");
    exit;
}
?>