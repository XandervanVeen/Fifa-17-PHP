<?php
require 'config.php';
// This checks if the user came to this page using a post request so that user cannot just
// visit this website
if ( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
    header('Location: index.php');
    exit;
};
session_start();
$id = $_SESSION['id'];

// Retrieve all teams
$sql = "SELECT * FROM teams";
$query = $db->query($sql);
$teams = $query->fetchAll(PDO::FETCH_ASSOC);

// This sets the name and players so we can check if they are empty or not
if (isset($_POST['name']) && !empty($_POST['name'])){
    $name = htmlentities(trim($_POST['name']));
}
else if ($_POST['type'] != 'delete' && $_POST['type'] != 'addPlayer' && $_POST['type'] != 'addPlayerSolo') {
    header('Location: error.php?error=Er is niks ingevuld bij naam');
    exit;
}

// If the post type is add
if ($_POST['type'] === 'add') {
    if (strlen($name) > 64) {
        header('Location: error.php?error=Het ingevulde team naam is te lang (Het maximale is 64)');
        exit;
    }
    foreach ($teams as $key => $val) {
        if (strtolower($val['name']) == strtolower($name)) {
            header('Location: error.php?error=Het ingevulde team naam bestaat al');
            exit;
        }
    }

    $sql = "INSERT INTO teams (name, players, creator)
        VALUES ( :name, :players, :creator )";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':name'    => $name,
        ':players' => $id,
        ':creator' => $id
    ]);

    $sql = "SELECT * FROM teams WHERE creator = :creator";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':creator' => $id
    ]);
    $currentTeam = $prepare->fetch(PDO::FETCH_ASSOC);

    $sql = "UPDATE users SET 
    teamid     = :teamid
    WHERE id = :id";
    $prepare= $db->prepare($sql);
    $prepare->execute([
        ':teamid'      => htmlentities(trim($currentTeam['id'])),
        ':id'          => htmlentities(trim($id))
    ]);
    header('Location: team-overview.php');
}

// If the post type is edit
if ($_POST['type'] === 'edit') {
    if (strlen($name) > 64) {
        header('Location: error.php?error=Het ingevulde team naam is te lang (Het maximale is 64)');
        exit;
    }
    // Retrieve all teams
    $sql = "SELECT * FROM teams";
    $query = $db->query($sql);
    $teams = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach ($teams as $key => $val) {
        if (strtolower($val['name']) == strtolower($name)) {
            if ($val['id'] == htmlentities(trim($_POST['id']))) {
            }
            else {
                header('Location: error.php?error=Het ingevulde team naam bestaat al');
                exit;
            }
        }
    }
    $sql = "UPDATE teams SET 
    name     = :name
    WHERE id = :id";
    $prepare= $db->prepare($sql);
    $prepare->execute([
        ':name'      => htmlentities(trim($_POST['name'])),
        ':id'        => htmlentities(trim($_POST['id']))
    ]);
    header("Location: team-overview.php");
    exit;
}

// If the post type is delete
if ($_POST['type'] === 'delete') {
    $id = $_POST['id'];

    // Retrieve the current team we are about to delete and set the creator his team id to 0
    $sql = "SELECT * FROM teams WHERE id = :id";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':id' => $id
    ]);
    $currentTeam = $prepare->fetch(PDO::FETCH_ASSOC);

    $currentTeamAllPlayers = explode(",", $currentTeam['players']);
    $currentTeamAllPlayersCount = count($currentTeamAllPlayers);

    for ($i = 0; $i < $currentTeamAllPlayersCount; $i++){
        $sql = "UPDATE users SET 
        teamid     = :teamid
        WHERE id = :id";
        $prepare= $db->prepare($sql);
        $prepare->execute([
            ':teamid'      => 0,
            ':id'          => $currentTeamAllPlayers[$i]
        ]);
    }
    $sql = "DELETE FROM teams WHERE id = :id";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':id' => $id
    ]);
    header("Location: team-overview.php");
    exit;
}
// If the post type is add player
if ($_POST['type'] === 'addPlayer') {
    $playerID = $_POST['playerID'];
    $teamID = $_POST['teamID'];

    $sql = "SELECT * FROM teams WHERE id = :id";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':id' => $teamID
    ]);
    $currentTeam = $prepare->fetch(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM users WHERE id = :id";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':id' => $playerID
    ]);
    $currentUser = $prepare->fetch(PDO::FETCH_ASSOC);

    $allPlayersCurrentTeam = explode(",", $currentTeam['players']);
    $allPlayersCurrentTeamCount = count($allPlayersCurrentTeam);
    foreach ($allPlayersCurrentTeam as $key => $val) {
        if ($val == $currentUser['id']) {
            $team1 = $val;
            header('Location: error.php?error=De geselecteerde gebruiker zit al in het team (Het kan zijn dat er te snel werd geklikt)');
            exit;
        }
    }

    $playersToAdd = $currentTeam['players'] . "," . $currentUser['id'];

    $sql = "UPDATE teams SET 
    players     = :players
    WHERE id = :id";
    $prepare= $db->prepare($sql);
    $prepare->execute([
        ':players'      => $playersToAdd,
        ':id'           => $teamID
    ]);

    $sql = "UPDATE users SET
    teamid     = :teamid
    WHERE id = :id";
    $prepare= $db->prepare($sql);
    $prepare->execute([
        ':teamid'      => $teamID,
        ':id'          => $playerID
    ]);
    header("Location: editTeam.php?id={$teamID}");
    exit;
}
// If the post type is add player solo
if ($_POST['type'] === 'addPlayerSolo') {
    $playerID = $id;
    $teamID = $_POST['id'];

    $sql = "SELECT * FROM teams WHERE id = :id";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':id' => $teamID
    ]);
    $currentTeam = $prepare->fetch(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM users WHERE id = :id";
    $prepare = $db->prepare($sql);
    $prepare->execute([
        ':id' => $playerID
    ]);
    $currentUser = $prepare->fetch(PDO::FETCH_ASSOC);

    $allPlayersCurrentTeam = explode(",", $currentTeam['players']);
    $allPlayersCurrentTeamCount = count($allPlayersCurrentTeam);
    foreach ($allPlayersCurrentTeam as $key => $val) {
        if ($val == $currentUser['id']) {
            $team1 = $val;
            header('Location: error.php?error=De geselecteerde gebruiker zit al in het team (Het kan zijn dat er te snel werd geklikt)');
            exit;
        }
    }

    $playersToAdd = $currentTeam['players'] . "," . $currentUser['id'];

    $sql = "UPDATE teams SET 
    players     = :players
    WHERE id = :id";
    $prepare= $db->prepare($sql);
    $prepare->execute([
        ':players'      => $playersToAdd,
        ':id'           => $teamID
    ]);

    $sql = "UPDATE users SET
    teamid     = :teamid
    WHERE id = :id";
    $prepare= $db->prepare($sql);
    $prepare->execute([
        ':teamid'      => $teamID,
        ':id'          => $playerID
    ]);
    header("Location: team-overview.php");
    exit;
}
?>
