<?php 
    function resetSeasonData($do_reset) {
        if ($do_reset == "true") {
            $mysqli = getConnection();

            if ($mysqli) {
                $mysqli->autocommit(FALSE);
                
                $success = true;
                $rollback = false;

                $query = "delete from batting_order where id > 0";
                if (! $mysqli->query($query) === TRUE) {
                    $rollback = true;
                }
                
                if (! $rollback) {
                    $query = "delete from player_position where player_id > 0";
                    if (! $mysqli->query($query) === TRUE) {
                        $rollback = true;
                    }
                }
                
                if (! $rollback) {
                    $query = "delete from GAME where id > 0";
                    if (! $mysqli->query($query) === TRUE) {
                        $rollback = true;
                    }                    
                }
                
                if (! $rollback) {
                    $query = "delete from player where id > 0";
                    if (! $mysqli->query($query) === TRUE) {
                        $rollback = true;
                    }    
                }
                
                if (! $rollback) {
                    $query = "delete from coach where id > 1";
                    if (! $mysqli->query($query) === TRUE) {
                        $rollback = true;
                    }                    
                }
                
                if (! $rollback) {
                    $query = "delete from coach_wip where id > 0";
                    if (! $mysqli->query($query) === TRUE) {
                        $rollback = true;
                    }    
                }
                
                if (! $rollback) {
                    $query = "delete from team where id > 1";
                    if (! $mysqli->query($query) === TRUE) {
                        $rollback = true;
                    }                    
                }                
                
                if ($rollback) {
                    $mysqli->rollback();
                    $success = false;
                } else {
                    $mysqli->commit();
                }

                $mysqli->close();

                return $success;
            } // else we could not connect to the DB        
        } else {
            return false;
        }
    }
?>
