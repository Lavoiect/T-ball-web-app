<?php
    session_start();
    $auth = $_SESSION["auth"];
    $coach = $_SESSION["coach"];
    $coach_id = $_SESSION["coach_id"];

    include 'inc/db.php';
    include 'inc/db_game.php';

    if (!$auth) {
        header("Location: login.php");
    }

    $q_game_id = $_GET["game_id"];
    
    if ($q_game_id == '') {
        header("Location: error.php");
    } else {

    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <style>
            label {
                font-weight: bold;
            }
            .err {
                color: red;
            }
        </style>
        <script>
            <?php echo "var gameId = " . $q_game_id . ";"; ?>
        </script>
    </head>
    <body>
        <h1>Team: <?php echo getTeamNameForGame($q_game_id) ?></h1>
        <h2>Game: <?php echo getGameName($q_game_id) ?></h2>

        <form id="rosterForm">
            <label for="nbrOfInnings">Number of Innings </label>
            <br /><select id="nbrOfInnings" autofocus="autofocus">
                <option value="0">Select Number of Innings</option>
                <option value="3">3</option>
                <option value="5">5</option>
                <option value="7">7</option>
                <option value="9">9</option>
            </select>
            <br /><button class="submit" type="submit">Generate Line-up</button>
        </form>
        <div id="msgDiv" class="err"></div>
        
        <div id="rosterDiv"></div>
       
        <?php include("inc/scripts.php"); ?>
        <script src="js/roster_scripts.js"></script>
    </body>
</html>
