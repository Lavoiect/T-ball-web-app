<?php
    session_start();
    $auth = $_SESSION["auth"];
    $coach = $_SESSION["coach"];

    if (!$auth) {
        header("Location: login.php");
    }

    //error_reporting(E_ALL);
    //ini_set("display_errors","On");

    include 'inc/db.php';
    include 'inc/db_user.php';
    include 'inc/db_team.php';
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
                <div id="user">Welcome Coach <?php echo $coach ?>. <a href="logout.php">Logout </a><i class="fa fa-user-o" aria-hidden="true"></i> </div>
            </div>
            <!-- End nav div-->

            <!-- Start tabs section -->        
            <div class="tab-panels">
                <ul class="tabs menu">
                    <li rel="playerTab" class="active">Players</li>
                    <li rel="positionTab">Positions</li>
                    <li rel="gameTab">Games</li>
                </ul>

                <div id="playerTab" class="panel active">
                    <ul class="tabList">
                        <li><i class="fa fa-plus" aria-hidden="true"></i>Add Player</li>
                    </ul>
                </div>

                <div id="positionTab" class="panel">
                    <ul class="tabList">
                        <?php
                            $position = getPositions();
                            echo $position;
                        ?>
                        <li><i class="fa fa-plus" aria-hidden="true"></i>Add Position</li>
                    </ul>
                </div>

                <div id="gameTab" class="panel">
                    <ul class="tabList">
                        <li><i class="fa fa-plus" aria-hidden="true"></i>Add Game</li>
                    </ul>
                    <button class="generate">Generate Line-up</button>
                </div>
            </div>
            <!-- End tabs -->
        </div>
        
        <?php include("inc/scripts.php"); ?>
        <script src="scripts/manage_team_scripts.js"></script>
    </body>
</html>