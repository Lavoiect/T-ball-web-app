<?php 
    function getUserName($user_name) {
        $mysqli = getConnection();

        if ($mysqli) {
            $coach_name = "";
            $res = $mysqli->query("SELECT first_name FROM coach where user_name = '" . $user_name . "'");

            $num_rows = mysqli_num_rows($res);
            
            if ($num_rows == 1) {
                while ($row = $res->fetch_assoc()) {
                    $coach_name = $row['first_name'];
                }
            }

            $mysqli->close();

            return $coach_name;
        } // else we could not connect to the DB            
    }

    function getUserId($user_name) {
        $mysqli = getConnection();

        if ($mysqli) {
            $coach_id = "";
            $res = $mysqli->query("SELECT id FROM coach where user_name = '" . $user_name . "'");

            $num_rows = mysqli_num_rows($res);
            
            if ($num_rows == 1) {
                while ($row = $res->fetch_assoc()) {
                    $coach_id = $row['id'];
                }
            }

            $mysqli->close();

            return $coach_id;
        } // else we could not connect to the DB            
    }

    function login($user_name, $pwd) {
        $mysqli = getConnection();

        if ($mysqli) {
            $success = false;
            $res = $mysqli->query("SELECT id FROM coach where user_name = '" . $user_name . "' and pwd = '" . $pwd . "'");

            $num_rows = mysqli_num_rows($res);
            
            if ($num_rows > 0) {
                $success = true;
                /*
                while ($row = $res->fetch_assoc()) {
                    echo "Coach: " . $row['id'] . "<br />";
                }
                */
            }

            $mysqli->close();

            return $success;
        } // else we could not connect to the DB    
    }

    function pendingRegistration($mysqli, $email, $q_id, $q_auth) {
        $pending_reg = false;
        
        $res = $mysqli->query("SELECT id FROM coach_wip where email = '" . $email . "' and id = " . intval($q_id) . " and coach_key = '" . $q_auth . "' and registered = 0");  

        $num_rows = mysqli_num_rows($res);

        if ($num_rows == 1) {
            $pending_reg = true;
        }
        
        return $pending_reg;
    }

    function  updateRegistration($mysqli, $email) {
        $res = $mysqli->query("UPDATE coach_wip SET registered = 1 where email = '" . $email . "'");  
    }


    function register($f_name, $l_name, $email, $user_name, $pwd, $q_id, $q_auth) {
            $mysqli = getConnection();
            if ($mysqli) {
                // check if email address is in COACH_WIP and has matching id and auth, and reg == 0
                if (pendingRegistration($mysqli, $email, $q_id, $q_auth)) {
                    $success = "success";
                    $res = $mysqli->query("SELECT id FROM coach where user_name = '" . $user_name . "'");

                    $num_rows = mysqli_num_rows($res);

                    if ($num_rows > 0) {
                        $success = "User Name already taken";
                    } else {
                        $res = $mysqli->query("SELECT id FROM coach where email = '" . $email . "'");

                        $num_rows = mysqli_num_rows($res);

                        if ($num_rows > 0) {
                            $success = "Email already taken";
                        }  else {
                            $res = $mysqli->query("SELECT team_id FROM coach_wip where email = '" . $email . "'");
                            
                            $team_id = 0;
                            while ($row = $res->fetch_assoc()) {
                                $team_id = $row['team_id'];
                            }
                            
                            // create new user
                            $query = "INSERT INTO coach (team_id, first_name, last_name, user_name, email, pwd) VALUES (" . $team_id . ", '" . $f_name . "', '" . $l_name . "', '" . $user_name . "', '" . $email . "', '" . $pwd . "')";                    
                            if ($mysqli->query($query) === TRUE) {
                                //$last_id = $mysqli->insert_id;
                                //echo "New record created successfully. Last inserted ID is: " . $last_id;

                                // update COACH_WIP table
                                updateRegistration($mysqli, $email);
                            } else {
                                //echo "Error: " . $query . "<br>" . $mysqli->error;
                                $success = "System error. Unable to create User.";
                            }
                        }
                    }

                    $mysqli->close();

                    return $success;
                } else {
                    // User is not in DB. Admin must add User email address to beign Coach Registration process.
                    return "Please contact the site Admin to register.";
                }
            } // else we could not connect to the DB   
    }

    function register_BAK($f_name, $l_name, $email, $user_name, $pwd, $q_id, $q_auth) {
            $mysqli = getConnection();
            if ($mysqli) {
                // check if email address is in COACH_WIP and has matching id and auth, and reg == 0
                if (pendingRegistration($mysqli, $email, $q_id, $q_auth)) {
                    $success = "success";
                    $res = $mysqli->query("SELECT id FROM coach where user_name = '" . $user_name . "'");

                    $num_rows = mysqli_num_rows($res);

                    if ($num_rows > 0) {
                        $success = "User Name already taken";
                    } else {
                        $res = $mysqli->query("SELECT id FROM coach where email = '" . $email . "'");

                        $num_rows = mysqli_num_rows($res);

                        if ($num_rows > 0) {
                            $success = "Email already taken";
                        }  else {
                            // create new user
                            $query = "INSERT INTO coach (first_name, last_name, user_name, email, pwd) VALUES ('" . $f_name . "', '" . $l_name . "', '" . $user_name . "', '" . $email . "', '" . $pwd . "')";                    
                            if ($mysqli->query($query) === TRUE) {
                                //$last_id = $mysqli->insert_id;
                                //echo "New record created successfully. Last inserted ID is: " . $last_id;

                                // update COACH_WIP table
                                updateRegistration($mysqli, $email);
                            } else {
                                //echo "Error: " . $query . "<br>" . $mysqli->error;
                                $success = "System error. Unable to create User.";
                            }
                        }
                    }

                    $mysqli->close();

                    return $success;
                } else {
                    // User is not in DB. Admin must add User email address to beign Coach Registration process.
                    return "Please contact the site Admin to register.";
                }
            } // else we could not connect to the DB   
    }
?>
