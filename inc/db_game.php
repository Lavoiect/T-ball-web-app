<?php
    // This function utilized by roster.php.
    function getDymaniceGameData($game_id, $nbr_of_innings) {
        $mysqli = getConnection();    
        
        if ($mysqli) {
            $nbr_of_players = 9;
            $max_innings = ($nbr_of_players * intval($nbr_of_innings));
            $data = array();
            $res = $mysqli->query("SELECT 
                                        player.first_name, 
                                        player.last_name, 
                                        position.name,
                                        player_position.inning
                                    FROM 
                                        player, 
                                        position,
                                        player_position
                                    WHERE 
                                        player.id = player_position.player_id 
                                    AND 
                                        position.id = player_position.position_id 
                                    AND  
                                        player_position.game_id = " 
                                        . $game_id .
                                    " ORDER BY
                                        player_position.inning asc, player_position.position_id asc;
                                    ");

            $counter = 0;
            while ($row = $res->fetch_assoc()) {
                if ($counter < $max_innings) {
                    $data[] = $row;
                    $counter++;
                }
            }

            $mysqli->close();

            return json_encode($data);
        } // else we could not connect to the DB          
    }

    // This funct was utilized in roster_BAK.php.  
    // Keeping for now.
    function getGameData($game_id) {
        $mysqli = getConnection();    

        if ($mysqli) {
            $data = array();
            $res = $mysqli->query("SELECT 
                                        player.first_name, 
                                        player.last_name, 
                                        position.name,
                                        player_position.inning
                                    FROM 
                                        player, 
                                        position,
                                        player_position
                                    WHERE 
                                        player.id = player_position.player_id 
                                    AND 
                                        position.id = player_position.position_id 
                                    AND  
                                        player_position.game_id = " 
                                        . $game_id .
                                    " ORDER BY
                                        player_position.inning asc, player_position.position_id asc;
                                    ");

            while ($row = $res->fetch_assoc()) {
                $data[] = $row;
            }

            $mysqli->close();

            return json_encode($data);
        } // else we could not connect to the DB   
    }

    function getTeamNameForGame($game_id) {
        $mysqli = getConnection();    
        $game_name = "";

        if ($mysqli) {
            $res = $mysqli->query("SELECT game.team_id, team.name FROM game, team WHERE game.id = " . $game_id . " AND team.id = game.team_id");
            
            $num_rows = mysqli_num_rows($res);
            
            while ($row = $res->fetch_assoc()) {
                $game_name = $row['name'];
            }

            $mysqli->close();

            return $game_name;
        } // else we could not connect to the DB 
    }

    function getGameName($game_id) {
        $mysqli = getConnection();    
        $game_name = "";

        if ($mysqli) {
            $res = $mysqli->query("SELECT game_name FROM game WHERE id = " . $game_id);
            
            $num_rows = mysqli_num_rows($res);
            
            while ($row = $res->fetch_assoc()) {
                $game_name = $row['game_name'];
            }

            $mysqli->close();

            return $game_name;
        } // else we could not connect to the DB 
    }

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
