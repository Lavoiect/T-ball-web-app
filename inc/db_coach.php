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

    function generateRandomKey() {
        $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $random_string_length = 10;
        $string = '';
        $max = strlen($characters) - 1;
        for ($i = 0; $i < $random_string_length; $i++) {
            $string .= $characters[mt_rand(0, $max)];
        }
        return $string;
    }

    function resetPassword($email) {
        $mysqli = getConnection();
        
        if ($mysqli) {
            $success = false;
            $res = $mysqli->query("SELECT id FROM coach_wip where email = '" . $email . "' and registered = 1");
            
            $coach_id = 0;
            while ($row = $res->fetch_assoc()) {
                $coach_id = $row['id'];
            }

            $num_rows = mysqli_num_rows($res);
            
            if ($num_rows == 1) {
                $random = generateRandomKey();
                $res = $mysqli->query("UPDATE coach_wip SET coach_key = '" . $random . "', registered = 2 where email = '" . $email . "'");  
                
                // send email to coach
                $to = $email;
                $subject = "T-Ball Password Reset Request";
                $message = "Please use the link below to reset your password." . "\r\n";
                $message .=  "http://" . $_SERVER['SERVER_NAME'] . "/pwd_reset.php?id=" . $coach_id  . "&auth=" . $random . "\r\n\r\n";
                sendMail($to, $subject, $message);

                $msg = "To: " . $email . "\r\nSubject: " . $subject . "\r\nMessage: " . $message . "\r\n";

                // ToDo: Comment-out the following when deployed to prod webserver, as email will be sent
                // This is for loacl dev / testing only!
                writeToLog($msg);
                
                $success = true;
            }

            $mysqli->close();

            return $success;
        } // else we could not connect to the DB                    
    }

    function doReset($email, $pwd, $q_id, $q_auth) {
        $mysqli = getConnection();
        
        if ($mysqli) {
            $success = false;
            $res = $mysqli->query("SELECT id FROM coach_wip where email = '" . $email . "' and id = " . $q_id . " and coach_key = '". $q_auth . "' and registered = 2");
            $num_rows = mysqli_num_rows($res);
            
            if ($num_rows == 1) {
                $res = $mysqli->query("UPDATE coach_wip SET registered = 1 where email = '" . $email . "'");  
                $res = $mysqli->query("UPDATE coach SET pwd = '" . $pwd . "' where email = '" . $email . "'");  

                $success = true;
            }

            $mysqli->close();

            return $success;
        } // else we could not connect to the DB    
    }

    // ToDo: This function is HUGE, and should be refactored
    function addCoach($team_id, $coach_email) {
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
                $random = generateRandomKey();
                
                $res = $mysqli->query("SELECT id, registered FROM coach_wip where team_id = " . $team_id);
                $num_rows = mysqli_num_rows($res);
                if ($num_rows > 0) {
                    $success = "Team alrady assigned to a Coach.";
                } else {
                    // save in COACH_WIP
                    $query = "INSERT INTO coach_wip (team_id, email, coach_key) VALUES (" . $team_id . ", '" . $coach_email. "', '" . $random . "')";                    
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
                    
                    // ToDo: Comment-out the following when deployed to prod webserver, as email will be sent
                    // This is for loacl dev / testing only!
                    writeToLog($msg);
                }
            }
            
            $mysqli->close();
        } // else we could not connect to the DB            
        
        return $success;
    }
?>