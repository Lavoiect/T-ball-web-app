<?php
    session_start();
    $auth = $_SESSION["auth"];
    $coach = $_SESSION["coach"];

    if (!$auth) {
        header("Location: login.php");
    }

    error_reporting(E_ALL);
    ini_set("display_errors","On");

    include 'inc/db.php';
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

            <h2 class="dataList">Teams</h2>
            <div class="dataList">
                <ul>
                    <?php
                        $teams = json_decode(getTeams(), true);
                        foreach ($teams as $team) {
                            $team_name = $team['name'];
                            if ($team_name != '')
                            echo "<li value='" . $team['id'] . "'>" . $team_name ."</li>";   
                        }
                    ?>
                </ul>
            </div>
        </div>
        
        <?php include("inc/scripts.php"); ?>
    </body>
</html>