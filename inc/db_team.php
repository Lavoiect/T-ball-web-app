<?php
     function getTeams() {
        $mysqli = getConnection();

        if ($mysqli) {
            $teams = "";
            $res = $mysqli->query("SELECT id, name FROM team order by id asc");

            $num_rows = mysqli_num_rows($res);
            
            if ($num_rows > 0) {
                while ($row = $res->fetch_assoc()) {
                    $teams .= "<option value='" . $row['id'] . "'>" . $row['name'] ."</option>";
                }
            }

            $mysqli->close();

            return $teams;
        } // else we could not connect to the DB            
    }

    function addTeam($team_name) {
        $mysqli = getConnection();
        $success = "success";
        $coach_id = $_SESSION["coach_id"];

        if ($mysqli) {
            $res = $mysqli->query("SELECT id FROM team where name = '" . $team_name . "'");

            $num_rows = mysqli_num_rows($res);
            
            if ($num_rows > 0) {
                $success = "Team name aleady exists.";
            } else {
                $query = "INSERT INTO team (coach_id, name) VALUES (" . intval($coach_id) . ", '" . $team_name . "')";                    
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
            $positions = "";
            $res = $mysqli->query("SELECT id, name FROM position order by id asc");

            $num_rows = mysqli_num_rows($res);
            
            if ($num_rows > 0) {
                while ($row = $res->fetch_assoc()) {
                    $positions .= "<li value='" . $row['id'] . "'>" . $row['name'] ."</li>";
                }
            }

            $mysqli->close();

            return $positions;
        } // else we could not connect to the DB            
    }
?>
