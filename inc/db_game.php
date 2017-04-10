<?php
    function addGame($team_id, $game_name) {
        $mysqli = getConnection();    
        
        if ($mysqli) {
            $last_id = 0;
            
            $query = "INSERT INTO game (team_id, game_name) VALUES (" . $team_id . ", '" . $game_name . "')";
            if ($mysqli->query($query) === TRUE) {
                $last_id = $mysqli->insert_id;        
            } 
            
            $mysqli->close();
            
            return $last_id;
        } // else we could not connect to the DB           
    }

    function getGames() {
        $mysqli = getConnection();

        if ($mysqli) {
            $games = array();
            $res = $mysqli->query("SELECT id, game_name FROM game order by id asc");

            while ($row = $res->fetch_assoc()) {
                $games[] = $row;
            }

            $mysqli->close();

            return json_encode($games);
        } // else we could not connect to the DB            
    }
?>
