<?php
    session_start();
    $auth = $_SESSION["auth"];
    $coach = $_SESSION["coach"];
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
                <div id="user"><a href="login.php">Login <i class="fa fa-user-o" aria-hidden="true"></i></a></div>
            </div>
            <!-- End nav div-->
            
            <div class="greating">An error has occurred!</div>       
        </div>
        
        <?php include("inc/scripts.php"); ?>
	</body>
</html>