<?php
    function getBattingOrder($game_id) {
        $mysqli = getConnection(); 
        $bat_order = 0;
        $team_id = 0;
        
        if ($mysqli) {
            $res = $mysqli->query("SELECT 
                                        batting_order.bat_order,
                                        game.team_id
                                    FROM 
                                        batting_order, 
                                        game
                                    WHERE 
                                        batting_order.team_id = game.team_id 
                                    AND  
                                        game.id = " . $game_id);
            
            
            while ($row = $res->fetch_assoc()) {
                $bat_order = $row['bat_order'];
                $team_id = $row['team_id'];
            }
            
            $new_bat_order = $bat_order;
            if ($bat_order < 9) {
                $new_bat_order++;
            } else {
                $new_bat_order = 1;
            };
            
            $res = $mysqli->query("UPDATE batting_order SET bat_order = " . $new_bat_order . " WHERE team_id = " . $team_id);  
            
            $mysqli->close();
        }

        return $bat_order;
    }

function getLeadPlayer($game_id) {
        $mysqli = getConnection(); 
        $lead_player = 0;
        $team_id = 0;
        
        if ($mysqli) {
            $res = $mysqli->query("SELECT 
                                        batting_order.lead_player,
                                        game.team_id
                                    FROM 
                                        batting_order, 
                                        game
                                    WHERE 
                                        batting_order.team_id = game.team_id 
                                    AND  
                                        game.id = " . $game_id);
            
            
            while ($row = $res->fetch_assoc()) {
                $lead_player = $row['lead_player'];
                $team_id = $row['team_id'];
            }
            
            $new_lead_player = $lead_player;
            if ($lead_player < 9) {
                $new_lead_player++;
            } else {
                $new_lead_player = 1;
            };
            
            $res = $mysqli->query("UPDATE batting_order SET lead_player = " . $new_lead_player . " WHERE team_id = " . $team_id);  
            
            $mysqli->close();
        }

        return $lead_player;
    }

    function getNbrOfPlayers($game_id) {
        $mysqli = getConnection(); 
        $nbr_of_players = 0;
        
        if ($mysqli) {
            $res = $mysqli->query("SELECT 
                                        player.id
                                    FROM 
                                        player, 
                                        game
                                    WHERE 
                                        player.team_id = game.team_id 
                                    AND  
                                        game.id = " . $game_id);
            
            $nbr_of_players = mysqli_num_rows($res);

            $mysqli->close();
        }

        return $nbr_of_players;
    }

    function generatePlayerPositions($game_id, $nbr_of_innings) {
        $mysqli = getConnection(); 

        if ($mysqli) {
            $res = $mysqli->query("SELECT 
                                        player.id
                                    FROM 
                                        player, 
                                        game
                                    WHERE 
                                        player.team_id = game.team_id 
                                    AND  
                                        game.id = " . $game_id . " ORDER BY player.id");

            $positions = array(1, 2, 3, 4, 5, 6, 7, 8, 9);
            $players = array();
            while ($row = $res->fetch_assoc()) {
                $players[] = $row['id'];
            }
            $bat_order = array(1, 2, 3, 4, 5, 6, 7, 8, 9);
            
            $lead_player = getLeadPlayer($game_id);
            $max = 10 - $lead_player;
            $wip_indx = $lead_player - 1;
            $new_bat_order = array_slice($bat_order,$wip_indx,$max);
            
            $len = 9 - sizeof($players);
            for ($indx = 1; $indx <= $len; $indx++) {
                $new_bat_order[] = $indx;
            }
            
            $the_inning = 1;
            
            while ($the_inning <= $nbr_of_innings) {
                $curr_bat_order = getBattingOrder($game_id);

                $max = 10 - $curr_bat_order;
                $wip_indx = $curr_bat_order - 1;

                $new_positions = array_slice($positions,$wip_indx,$max);
                $new_players   = array_slice($players,$wip_indx,$max);
                //$new_bat_order = array_slice($bat_order,$wip_indx,$max);

                $len = 9 - sizeof($new_positions);
                for ($indx = 1; $indx <= $len; $indx++) {
                    $new_positions[] = $indx;
                    $new_players[] = $indx;
                    //$new_bat_order[] = $indx;
                }

                $len = sizeof($players);
                for ($indx = 0; $indx <= $len; $indx++) {
                    $query = "INSERT INTO player_position (player_id, position_id, game_id, inning, bat_order) VALUES (" . $players[$indx] . ", " . $new_positions[$indx] .  ", " . $game_id . ", " . $the_inning . ", " . $bat_order[$indx] . ")";
                    $mysqli->query($query);
                }
                
                $the_inning++;
            }

            $mysqli->close();
        }
    }

    // Used to create persist new Game Roster data
    function getDymanicGameData($game_id, $nbr_of_innings) {
        $mysqli = getConnection();    
        
        if ($mysqli) {
            generatePlayerPositions($game_id, $nbr_of_innings);
            
            $nbr_of_players = getNbrOfPlayers($game_id);
            $max_positions = ($nbr_of_players * intval($nbr_of_innings));
            $data = array();
            $res = $mysqli->query("SELECT 
                                        player.first_name, 
                                        player.last_name, 
                                        position.name,
                                        player_position.inning,
                                        player_position.bat_order
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
                if ($counter < $max_positions) {
                    $data[] = $row;
                    $counter++;
                }
            }

            $mysqli->close();

            return json_encode($data);
        } // else we could not connect to the DB          
    }

    // Used for pulling already persisted Game Roster data
    function getGameData($game_id) {
        $mysqli = getConnection();    

        if ($mysqli) {
            $data = array();
            $res = $mysqli->query("SELECT 
                                        player.first_name, 
                                        player.last_name, 
                                        position.name,
                                        player_position.inning,
                                        player_position.bat_order
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

    function getGames($team_id) {
        $mysqli = getConnection();

        if ($mysqli) {
            $games = array();
            $res = $mysqli->query("SELECT id, game_name FROM game WHERE team_id = " . $team_id . " order by id asc");

            while ($row = $res->fetch_assoc()) {
                $games[] = $row;
            }

            $mysqli->close();

            return json_encode($games);
        } // else we could not connect to the DB            
    }
?>
