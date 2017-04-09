<?php
     function getTeams() {
        $mysqli = getConnection();

        if ($mysqli) {
            $teams = array();
            $res = $mysqli->query("SELECT id, name FROM team order by id asc");

            while ($row = $res->fetch_assoc()) {
                $teams[] = $row;
            }

            $mysqli->close();

            return json_encode($teams);
        } // else we could not connect to the DB            
    }

    function getTeamName($coach_id) {
        $mysqli = getConnection();
        $team_name = "";

        if ($mysqli) {
            $res = $mysqli->query("SELECT team.name FROM team INNER JOIN coach ON team.id = coach.team_id WHERE coach.id = " . $coach_id);
            
            $num_rows = mysqli_num_rows($res);
            
            while ($row = $res->fetch_assoc()) {
                $team_name = $row['name'];
            }

            $mysqli->close();

            return $team_name;
        } // else we could not connect to the DB 
    }

    function getTeamId($coach_id) {
        $mysqli = getConnection();
        $team_id = 1;

        if ($mysqli) {
            $res = $mysqli->query("SELECT team.id FROM team INNER JOIN coach ON team.id = coach.team_id WHERE coach.id = " . $coach_id);
            
            $num_rows = mysqli_num_rows($res);
            
            while ($row = $res->fetch_assoc()) {
                $team_id = $row['id'];
            }

            $mysqli->close();

            return $team_id;
        } // else we could not connect to the DB 
    }

    function getTeamInfo($coach_id) {
        $mysqli = getConnection();
        $team_info = array();

        if ($mysqli) {
            $res = $mysqli->query("SELECT team.id, team.name FROM team INNER JOIN coach ON team.id = coach.team_id WHERE coach.id = " . $coach_id);
            
            $num_rows = mysqli_num_rows($res);
            
            while ($row = $res->fetch_assoc()) {
                $team_info[] = $row;
            }

            $mysqli->close();

            return json_encode($team_info);
        } // else we could not connect to the DB 
    }

    function addTeam($team_name) {
        $mysqli = getConnection();
        $success = "success";

        if ($mysqli) {
            $res = $mysqli->query("SELECT id FROM team where name = '" . $team_name . "'");

            $num_rows = mysqli_num_rows($res);
            
            if ($num_rows > 0) {
                $success = "Team name aleady exists.";
            } else {
                $query = "INSERT INTO team (name) VALUES ('" . $team_name . "')";                    
                if ($mysqli->query($query) === TRUE) {
                    // Team inserted
                } else {
                    $success = "Unable to create Team.";
                }
            }

            $mysqli->close();

            return $success;
        } // else we could not connect to the DB 
    }

    function getPositions() {
        $mysqli = getConnection();

        if ($mysqli) {
            $positions = array();
            $res = $mysqli->query("SELECT id, name FROM position order by id asc");

            while ($row = $res->fetch_assoc()) {
                $positions[] = $row;
            }

            $mysqli->close();

            return json_encode($positions);
        } // else we could not connect to the DB            
    }
?>
