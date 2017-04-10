<?php
    session_start();

    include 'inc/db.php';
    include 'inc/db_position.php';

    $data = ['ERROR' => 'ERROR'];

    if (count($_POST) > 0) {
        $position_name = $_POST["position_name"];
        
        if ($position_name != "") {
            $position_id = addPosition($position_name);
            if ($position_id > 0) {
                $data = ['position_id' => $position_id];
            } else {
                $data = ['ERROR' => 'Position already exists.'];
            }
        } 
    } // else show page

    echo json_encode($data);
?>