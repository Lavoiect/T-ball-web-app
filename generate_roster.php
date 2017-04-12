<?php
    session_start();

    include 'inc/db.php';
    include 'inc/db_game.php';

    $data = ['ERROR' => 'ERROR'];

    if (count($_POST) > 0) {
        $game_id = $_POST["game_id"];
        $nbr_of_innings = $_POST["nbr_of_innings"];

        if ($game_id != "" && $nbr_of_innings != "") {
            $nbr_of_players = getNbrOfPlayers($game_id);

            if ($nbr_of_players > 0) {
                $game_data = getDymanicGameData($game_id, $nbr_of_innings);
                
                if (sizeof($game_data) > 0) {
                    $data = $game_data;
                } else {
                    $data = ['ERROR' => 'Unable to generate Line-up.'];
                }
            } else {
                $data = ['ERROR' => 'No Players found for this Team.'];
            }
        } 
    } // else show page

    echo json_encode($data);
?>