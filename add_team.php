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

    $msg = "";
    $team_name = "";

    if (count($_POST) > 0) {
        $team_name = $_POST["teamName"];

        if ($team_name != "") {
            $success = addTeam($team_name);

            if ($success == "success") {
                header("Location: manage_team.php");
            } else {
                $msg = $success;
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
                <div id="user">Welcome Coach <?php echo $coach ?>. <a href="logout.php">Logout </a><i class="fa fa-user-o" aria-hidden="true"></i> </div>
            </div>
            <!-- End nav div-->
        
            <form action="add_team.php" method="POST">
                <label for="teamName">Team Name:</label>
                <input id="teamName" name="teamName" type="text" required="required" value="<?php echo $team_name ?>" autofocus="autofocus"><br />
                <button class="submit" type="submit">Add Team</button>
            </form>  
            
            <?php if($msg != "") : ?>
                <div class="err">Error: <?php echo $msg ?></div>
            <?php endif; ?>
            
            <p>You will need to add players to your roster and define the positions for your team in the next step.</p>
        </div>
        
        <?php include("inc/scripts.php"); ?>
    </body>
</html>