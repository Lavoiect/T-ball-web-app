<?php
    function sendMail($to, $subject, $message) {
        // ToDo: Change to Admin's email address!
        $admin_email = "lavoiect@gmail.com";
        
        $headers =  'From: ' . $admin_email . "\r\n" .
                    'Reply-To: ' . $admin_email . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);
    }
?>