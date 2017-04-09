<?php
    function addPlayer($team_id, $f_name, $l_name) {
        $mysqli = getConnection();    
        
        if ($mysqli) {
            $last_id = 0;
            
            $query = "INSERT INTO player (team_id, first_name, last_name) VALUES (" . $team_id . ", '" . $f_name . "', '" . $l_name . "')";
            if ($mysqli->query($query) === TRUE) {
                $last_id = $mysqli->insert_id;        
            } 
            
            $mysqli->close();
            
            return $last_id;
        } // else we could not connect to the DB           
    }

    function getPlayers($team_id) {
        $mysqli = getConnection();

        if ($mysqli) {
            $players = array();
            $res = $mysqli->query("SELECT player.id, player.first_name, player.last_name FROM player INNER JOIN team ON player.team_id = team.id WHERE team.id = " . $team_id);

            while ($row = $res->fetch_assoc()) {
                $players[] = $row;
            }

            $mysqli->close();

            return json_encode($players);
        } // else we could not connect to the DB            
    }
?>
