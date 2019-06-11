<?php
// Makes sure we have all the data needed to connect to the data base
require 'config.php';
//require 'icon.html';
// This checks if the user came to this page using a post request so that user cannot just
// visit this website
if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
    header('Location: index.php');
    exit;
};
// If the post type is add
if ($_POST['type'] === 'add'){
    $sql = "SELECT * FROM fields";
    $query = $db->query($sql);
    $fields = $query->fetchAll(PDO::FETCH_ASSOC);
    // This sets the fieldNumber so we can check if they are empty or not
    if (isset($_POST['fieldNumber']) && !empty($_POST['fieldNumber'])){
        $fieldNumber = htmlentities(trim($_POST['fieldNumber']));
        if (!is_numeric($fieldNumber)){
            header('Location: error.php?error=Het ingevulde veld moet een nummer zijn');
            exit;
        }
    }
    else {
        header('Location: error.php?error=Er is niks ingevuld bij veld nummer');
        exit;
    }
    // This looks true all fields to see if it can find and item in the database
    // which already contains the field number
    foreach ($fields as $key => $val) {
        if ($val['fieldNumber'] == $fieldNumber) {
            header('Location: error.php?error=Het veld bestaat al');
            exit;
        }
    }
    $sql = "INSERT INTO fields (fieldNumber)
    VALUES ( :fieldNumber )";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':fieldNumber'  => $fieldNumber
    ]);
    header('Location: addField.php');
    exit;
}
// If the post type is delete
if ($_POST['type'] === 'delete') {
    $id = $_POST['id'];
    $sql = "DELETE FROM fields WHERE id = :id";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':id' => $id
    ]);
    header("Location: addField.php");
    exit;
}
