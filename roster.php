<?php
    session_start();
    $auth = $_SESSION["auth"];
    $coach = $_SESSION["coach"];
    $coach_id = $_SESSION["coach_id"];

    include 'inc/db.php';
    include 'inc/db_game.php';

    if (!$auth) {
        header("Location: login.php");
    }

    $q_game_id = $_GET["game_id"];
    
    if ($q_game_id == '') {
        header("Location: error.php");
    } else {
        $gameData = getGameData($q_game_id);
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head></head>
    <body>
        <h1>Team: </h1>
        <h2>Game: </h2>

        <h3>First Inning</h3>
        <table border="1">
            <thead>
                <tr>
                    <th>Player</th>
                    <th>Position</th>
                </tr>
            </thead>
            <tbody id="firstInning"></tbody>
        </table> 

        <h3>Second Inning</h3>
        <table border="1">
            <thead>
                <tr>
                    <th>Player</th>
                    <th>Position</th>
                </tr>
            </thead>
            <tbody id="secondInning"></tbody>
        </table> 

        <h3>Third Inning</h3>
        <table border="1">
            <thead>
                <tr>
                    <th>Player</th>
                    <th>Position</th>
                </tr>
            </thead>
            <tbody id="thirdInning"></tbody>
        </table>    
    </body>
</html>
