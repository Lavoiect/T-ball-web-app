<?php
    session_start();

    include 'inc/db.php';
    include 'inc/db_reset_season.php';

    $success = ['ERROR' => 'ERROR'];

    if (count($_POST) > 0) {
        $do_reset = $_POST["do_reset"];
        
        if ($do_reset == "true") {
            $season_reset = resetSeasonData($do_reset);
            if ($season_reset) {
                $success = ['success' => 'true'];
            }
        } 
    } // else show page

    echo json_encode($success);
?>