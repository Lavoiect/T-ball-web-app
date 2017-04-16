<?php
    function addPosition($position_name) {
        $mysqli = getConnection();    
        
        if ($mysqli) {
            $last_id = 0;
            
            $query = "INSERT INTO position (name) VALUES ('" . $position_name . "')";
            if ($mysqli->query($query) === TRUE) {
                $last_id = $mysqli->insert_id;        
            } 
            
            $mysqli->close();
            
            return $last_id;
        } // else we could not connect to the DB           
    }

    function getPositions() {
        $mysqli = getConnection();

        if ($mysqli) {
            $positions = array();
            $res = $mysqli->query("SELECT id, name FROM position order by list_order asc");

            while ($row = $res->fetch_assoc()) {
                $positions[] = $row;
            }

            $mysqli->close();

            return json_encode($positions);
        } // else we could not connect to the DB            
    }
?>
