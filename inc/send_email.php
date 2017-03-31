<?php
    function sendMail($to, $subject, $message) {
        // TBD: Change to Admin's email address!
        $admin_email = "foo@bar.com";
        
        $headers =  'From: ' . $_admin_email . "\r\n" .
                    'Reply-To: ' . $_admin_email . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);
    }
?>