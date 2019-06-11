<?php
require 'config.php';
//require  'style.php';
if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
    header('Location: index.php');
    exit;
};
// If the post type is add
if ($_POST['type'] === 'add'){
    $sql = "SELECT * FROM referee";
    $query = $db->query($sql);
    $referees = $query->fetchAll(PDO::FETCH_ASSOC);
    // This sets the refereeName so we can check if they are empty or not
    if (isset($_POST['refereeName']) && !empty($_POST['refereeName'])){
        $refereeName = htmlentities(trim($_POST['refereeName']));
    }
    else {
        header('Location: error.php?error=Er is niks ingevuld bij scheidsrechter');
        exit;
    }
    // This looks true all referees to see if it can find and item in the database
    // which already contains the referee name
    foreach ($referees as $key => $val) {
        if (strtolower($val['name']) == strtolower($refereeName)) {
            header('Location: error.php?error=Het ingevulde naam bestaat al');
            exit;
        }
    }
    $sql = "INSERT INTO referee (name)
    VALUES ( :name )";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':name'  => $refereeName
    ]);
    header('Location: addReferee.php');
    exit;
}
// If the post type is delete
if ($_POST['type'] === 'delete') {
    $id = $_POST['id'];
    $sql = "DELETE FROM referee WHERE id = :id";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':id' => $id
    ]);
    header("Location: addReferee.php");
    exit;
}