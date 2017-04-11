<?php
    session_start();

    include 'inc/db.php';
    include 'inc/db_game.php';

    $data = ['ERROR' => 'ERROR'];

    if (count($_POST) > 0) {
        $t_id = $_POST["team_id"];
        $game_name = $_POST["game_name"];
        
        if ($t_id != "" && $game_name != "") {
            $game_id = addGame($t_id, $game_name);
            if ($game_id > 0) {
                $data = ['game_id' => $game_id];
            } else {
                $data = ['ERROR' => 'Game already entered for Team.'];
            }
        } 
    } // else show page


    echo json_encode($data);
?>