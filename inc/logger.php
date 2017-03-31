<?php
    function writeToLog($msg) {
        $log_file = "logs/tball.log";
        $log = fopen($log_file, "w") or die("Unable to open log file!");
        
        fwrite($log, $msg);

        fclose($log);
    }
?>