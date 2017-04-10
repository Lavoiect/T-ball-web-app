<?php
    session_start();
    $auth = $_SESSION["auth"];

    include 'inc/db.php';
    include 'inc/db_coach.php';
    include 'inc/send_email.php';
    include 'inc/logger.php';

    if ($auth) {
        header("Location: index.php");
    }

    $valid = true;
    $processed = false;

    if (count($_POST) > 0) {
        $email = $_POST["email"];

        if ($email != "") {
            $success = resetPassword($email);

            if ($success) {
                $processed = true;
            } else {
                $valid = false;
            }
        } 
    } // else show page
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("inc/head.php"); ?>
    </head>
    <body>
        <div class="application">
            <?php include("inc/header.php"); ?>

            <!-- Start nav div-->
            <div class="nav">
                <a href="index.php"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
            </div>
            <!-- End nav div-->
        
            <?php if($processed) : ?>
                <h3 class="header">Please use the link in the email which was just sent to reset your password.</h3>
            <?php else: ?>
                <h3 class="header">Password Reset Form</h3>
                <form id="resetForm" action="reset.php" method="POST">
                    <label for="email">Email:</label>
                    <input id="email" name="email" type="email" required="required" autofocus="autofocus" /><br />

                    <button type="submit">Submit</button>
                </form>  
            <?php endif; ?>
                                                
            <?php if(! $valid) : ?>
                <div class="err">Error: Email Address not registered.</div>
            <?php endif; ?>
        </div>
        
        <?php include("inc/scripts.php"); ?>
    </body>
</html>