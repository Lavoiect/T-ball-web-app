<?php
    session_start();
    $auth = $_SESSION["auth"];
    $coach = $_SESSION["coach"];
    $coach_id = $_SESSION["coach_id"];

    if (!$auth) {
        header("Location: login.php");
    }

    error_reporting(E_ALL);
    ini_set("display_errors","On");

    include 'inc/db.php';
    include 'inc/db_user.php';
    include 'inc/db_team.php';

    $team_name = getTeamName($coach_id);
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
               <h2 class="teamName"><?php echo $team_name ?></h2>
                <ul class="tabs menu">
                    <li rel="playerTab" class="active">Players</li>
                    <li rel="positionTab">Positions</li>
                    <li rel="gameTab">Games</li>
                </ul>

                <div id="playerTab" class="panel active">
                    <ul class="tabList">
                        <li><i class="fa fa-plus" aria-hidden="true"></i><a class="callInput" href="#">Add Player</a></li>
                    </ul>
                    <form class="popUpWindow" action="/action_page.php">
                    Player name: <input type="text" name="pname">
                    <input class="close" type="submit" value="Submit">
                    </form>
                </div>

                <div id="positionTab" class="panel">
                    <ul class="tabList">
                        <?php
                            $positions = json_decode(getPositions(), true);
                            foreach ($positions as $position) {
                                echo "<li value='" . $position['id'] . "'>" . $position['name'] ."</li>";
                            }
                        ?>
                        <li><i class="fa fa-plus" aria-hidden="true"></i><a class="callInput">Add Position</a></li>
                    </ul>
                    <form class="popUpWindow" action="/action_page.php">
                    Position: <input type="text" name="position">
                    <input class="close" type="submit" value="Submit">
                    </form>
                </div>

                <div id="gameTab" class="panel">
                    <ul class="tabList">
                        <li><i class="fa fa-plus" aria-hidden="true"></i><a class="callInput">Add Game</a></li>
                    </ul>
                    <form class="popUpWindow" action="/action_page.php">
                    Add Game: <input type="text" name="game">
                    <input class="close" type="submit" value="Submit">
                    </form>
                    <button class="generate">Generate Line-up</button>
                </div>
            </div>
            <!-- End tabs -->
        </div>

        <?php include("inc/scripts.php"); ?>
        <script src="js/manage_team_scripts.js"></script>
    </body>
</html>
