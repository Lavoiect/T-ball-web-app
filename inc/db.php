<?php
    function getConnection() {
        $server_name = "127.0.0.1";
        $user_name = "coach";
        $password = "password";
        $db = "tball";
        
        $mysqli = new mysqli($server_name, $user_name, $password, $db);
        if ($mysqli->connect_errno) {
            return null;
        } else {
            return $mysqli;
        }   
    }
?>
