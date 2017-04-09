<?php
    session_start();

    include 'inc/db.php';
    include 'inc/db_player.php';

    $data = ['ERROR' => 'ERROR'];

    if (count($_POST) > 0) {
        $t_id = $_POST["team_id"];
        $first_name = $_POST["f_name"];
        $last_name = $_POST["l_name"];
        
        if ($t_id != "" && $first_name != "" && $last_name != "") {
            $player_id = addPlayer($t_id, $first_name, $last_name);
            if ($player_id > 0) {
                $data = ['player_id' => $player_id];
            } else {
                $data = ['ERROR' => 'Player already assigned to Team.'];
            }
        } 
    } // else show page

    echo json_encode($data);
?>