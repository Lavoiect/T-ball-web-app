<?php
    session_start();

    include 'inc/db.php';
    include 'inc/db_game.php';

    $data = ['ERROR' => 'ERROR'];

    if (count($_POST) > 0) {
        $game_id = $_POST["game_id"];
        $nbr_of_innings = $_POST["nbr_of_innings"];
        
        if ($game_id != "" && $nbr_of_innings != "") {
            $game_data = getDymaniceGameData($game_id, $nbr_of_innings);
            if (sizeof($game_data) > 0) {
                $data = $game_data;
            } else {
                $data = ['ERROR' => 'Unable to generate Line-up.'];
            }
        } 
    } // else show page

    echo json_encode($data);
?>