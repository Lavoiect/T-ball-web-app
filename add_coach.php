<?php
    session_start();
    $auth = $_SESSION["auth"];
    $coach = $_SESSION["coach"];

    if (!$auth) {
        header("Location: login.php");
    }

    include 'inc/db.php';
    include 'inc/db_team.php';
    include 'inc/db_coach.php';
    include 'inc/send_email.php';
    include 'inc/logger.php';

    $msg ="";

    if (count($_POST) > 0) {
        $team_id = $_POST["teamName"]; 
        $email = $_POST["coachEmail"];

        if ($email != "") {
            $success = addCoach($team_id, $email);

            if ($success == "success") {
                header("Location: index.php");
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
        
            <form id="addCoachForm" action="add_coach.php" method="POST">
                <label for="teamName">Team Name</label>
                <select id="teamName" name="teamName">
                    <option value="1">Select a Team</option>
                    <?php
                        $teams = json_decode(getTeams(), true);
                        foreach ($teams as $team) {
                            $team_name = $team['name'];
                            if ($team_name != '')
                            echo "<option value='" . $team['id'] . "'>" . $team_name ."</option>";   
                        }
                    ?>
                </select>
                <br />
                <label for="coachEmail">Coach Email:</label>
                <input id="coachEmail" name="coachEmail" type="email" value="<?php echo $_POST["coachEmail"] ?>"  required="required" autofocus="autofocus"><br />
                <button class="submit" type="submit">Add Coach</button>
            </form>  
            
            <div id="msgDiv" class="err"></div>
            
            <?php if($msg != "") : ?>
                <div class="err">Error: <?php echo $msg ?></div>
            <?php endif; ?>
            
            <p>Coaches will be required to login in order to add Players to their Team.</p>
        </div>
        
        <?php include("inc/scripts.php"); ?>
        <script src="js/add_coach_scripts.js"></script>
    </body>
</html>