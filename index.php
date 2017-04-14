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
                    <div id="user">Welcome Coach <?php echo $coach ?>. <a href="logout.php">Logout </a><span class="icon-coach">
                <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span>
                </span> </div>
                <? else: ?>
                    <div id="user"><a href="login.php">Login <span class="icon-coach">
                <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span>
                </span></a></div>
                <?php endif; ?>
            </div>
            <!-- End nav div-->

            <?php if($auth) : ?>
                <div class="greating">Welcome to the line up and defensive positioning tool. Create a new team  or choose an existing one.</div>

                <div class="addTeam">
                    <?php if($coach == "Admin") : ?>
                        <a href="add_team.php"><img src="http://res.cloudinary.com/lavoie-media/image/upload/v1490676514/icon_a6906n.png" class="base" /></a>
                        <div class="iconLabel">Add Team</div>
                        <br />
                        <a href="add_coach.php"><img src="http://res.cloudinary.com/lavoie-media/image/upload/v1490676514/icon_a6906n.png" class="base" /></a>
                        <div class="iconLabel">Add Coach</div>
                        <br />
                        <a href="show_teams.php"><img src="http://res.cloudinary.com/lavoie-media/image/upload/v1490676514/icon_a6906n.png" class="base" /></a>
                        <div class="iconLabel">Show Teams</div>
                        <br />
                        <a href="show_coaches.php"><img src="http://res.cloudinary.com/lavoie-media/image/upload/v1490676514/icon_a6906n.png" class="base" /></a>
                        <div class="iconLabel">Show Coaches</div>
                        <br />
                        <a href="#" id="resetSeasonBtn"><img src="http://res.cloudinary.com/lavoie-media/image/upload/v1490676514/icon_a6906n.png" class="base" /></a>
                        <div class="iconLabel">Reset Season</div>
                    <? else: ?>
                        <a href="manage_team.php"><span class="icon-jersey-solid base"></span></a>
                        <div class="iconLabel">Manage Team</div>
                    <?php endif; ?>
                </div>
            <? else: ?>
                <div class="greating">Welcome to the line up and defensive positioning tool.  Please <a href="login.php">Login</a> to continue.</div>
            <?php endif; ?>
        </div>

        <?php include("inc/scripts.php"); ?>
        <?php if($coach == "Admin") : ?>
            <script src="js/reset_season_scripts.js"></script>
        <?php endif; ?>
	</body>
</html>
