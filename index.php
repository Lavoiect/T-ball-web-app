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
                <?php if($auth) : ?>
                    <div id="user">Welcome Coach <?php echo $coach ?>. <a href="logout.php">Logout </a><i class="fa fa-user-o" aria-hidden="true"></i> </div>
                <? else: ?>    
                    <div id="user"><a href="login.php">Login <i class="fa fa-user-o" aria-hidden="true"></i></a></div>
                <?php endif; ?>
            </div>
            <!-- End nav div-->
            
            <?php if($auth) : ?>
                <div class="greating">Welcome to the line up and defensive positioning tool. Create a new team  or choose an existing one.</div>
                
                <div class="addTeam">
                    <?php if($coach == "Admin") : ?>
                        <a href="add_coach.php"><img src="http://res.cloudinary.com/lavoie-media/image/upload/v1490676514/icon_a6906n.png" class="base" /></a>
                        <div class="iconLabel">Add Coach</div>
                        <br />
                        <a href="show_coaches.php"><img src="http://res.cloudinary.com/lavoie-media/image/upload/v1490676514/icon_a6906n.png" class="base" /></a>
                        <div class="iconLabel">Show Coaches</div>
                        <br />
                        <a href="show_teams.php"><img src="http://res.cloudinary.com/lavoie-media/image/upload/v1490676514/icon_a6906n.png" class="base" /></a>
                        <div class="iconLabel">Show Teams</div>
                    <? else: ?>    
                        <a href="add_team.php"><img src="http://res.cloudinary.com/lavoie-media/image/upload/v1490676514/icon_a6906n.png" class="base" /></a>
                        <div class="iconLabel">Add Team</div>
                        <br />
                        <a href="manage_team.php"><img src="http://res.cloudinary.com/lavoie-media/image/upload/v1490676514/icon_a6906n.png" class="base" /></a>
                        <div class="iconLabel">Manage Team</div>
                    <?php endif; ?>
                </div>
            <? else: ?>    
                <div class="greating">Welcome to the line up and defensive positioning tool.  Please <a href="login.php">Login</a> to continue.</div>
            <?php endif; ?>
        </div>
       
        <?php include("inc/scripts.php"); ?>
	</body>
</html>