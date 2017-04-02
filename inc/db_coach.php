<?php
     function getCoaches() {
        $mysqli = getConnection();

        if ($mysqli) {
            $coaches = array();
            $res = $mysqli->query("SELECT id, first_name, last_name, user_name, email FROM coach where user_name <> 'Admin' order by id asc");

            while ($row = $res->fetch_assoc()) {
                $coaches[] = $row;
            }

            $mysqli->close();

            return json_encode($coaches);
        } // else we could not connect to the DB            
    }

    function addCoach($coach_email) {
        $mysqli = getConnection();

        if ($mysqli) {
            $success = "success";
            $last_id = "0";
            
            $res = $mysqli->query("SELECT id, registered FROM coach_wip where email = '" . $coach_email . "'");

            $num_rows = mysqli_num_rows($res);
            
            if ($num_rows > 0) {
                $success = "Email address already registered.";
            } else {
                // generate random key
                $random = '';
                for ($i = 0; $i < 10; $i++) {
                    $random .= chr(mt_rand(33, 126));
                }
                $random = preg_replace('/[^a-zA-Z0-9\']/', '_', $random);           
                
                // save in COACH_WIP
                $query = "INSERT INTO coach_wip (email, coach_key) VALUES ('" . $coach_email. "', '" . $random . "')";                    
                if ($mysqli->query($query) === TRUE) {
                    $last_id = $mysqli->insert_id;
                    //echo "New record created successfully. Last inserted ID is: " . $last_id;
                } else {
                    //echo "Error: " . $query . "<br>" . $mysqli->error;
                    $success = "System error. Unable to create Coach.";
                }          
                
                // send email to coach
                $to = $coach_email;
                $subject = "Welcome to the line up and defensive positioning tool.";
                $message = "Please use the link below to complete your Coach registration." . "\r\n";
                $message .=  "http://" . $_SERVER['SERVER_NAME'] . "/register.php?id=" . $last_id  . "&auth=" . $random . "\r\n\r\n";
                sendMail($to, $subject, $message);
                
                $msg = "To: " . $coach_email . "\r\nSubject: " . $subject . "\r\nMessage: " . $message . "\r\n";
                writeToLog($msg);
            }
            
            $mysqli->close();
        } // else we could not connect to the DB            
        
        return $success;
    }
?>