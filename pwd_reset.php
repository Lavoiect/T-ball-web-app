<?php
    session_start();
    $auth = $_SESSION["auth"];

    $q_id = $_GET["id"];
    $q_auth = $_GET["auth"];

    include 'inc/db.php';
    include 'inc/db_coach.php';

    if ($auth) {
        header("Location: index.php");
    }

    $valid = true;

    if (count($_POST) > 0) {
        $email = $_POST["email"];
        $pwd = $_POST["password"];

        if ($email != "" && $pwd != "") {
            $success = doReset($email, $pwd, $q_id, $q_auth);

            if ($success) {
                header("Location: login.php");
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
        
            <form id="resetForm" action="pwd_reset.php?id=<?php echo $q_id?>&auth=<?php echo $q_auth?>" method="POST">
                <label for="email">Email:</label>
                <input id="useremailName" name="email" type="email" required="required" autofocus="autofocus" /><br />
                <label for="password">Password:</label>
                <input id="password" name="password" type="password" required="required" /><br />
                <label for="confirm">Confirm:</label>
                <input id="confirm" type="password" required="required" /><br />
                
                <button class="submit" type="submit">Submit</button>
            </form>  

            <div id="msgDiv" class="err"></div>
            
            <?php if(! $valid) : ?>
                <div class="err">Error: We were unable to reset your password. Please ensure you are using your registered email address.</div>
            <?php endif; ?>
        </div>
        
        <?php include("inc/scripts.php"); ?>
        <script src="js/pwd_reset_scripts.js"></script>
    </body>
</html>