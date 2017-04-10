<?php
    session_start();
    $auth = $_SESSION["auth"];
    $coach = $_SESSION["coach"];
    $coach_id = $_SESSION["coach_id"];

    if (!$auth) {
        header("Location: login.php");
    }

    include 'inc/db.php';
    include 'inc/db_user.php';
    include 'inc/db_team.php';
    include 'inc/db_player.php';
    include 'inc/db_position.php';
    include 'inc/db_game.php';

    $team_name = "";
    $team_id = 1;
    $team_info = json_decode(getTeamInfo($coach_id), true);

    foreach ($team_info as $team) {
        $team_name = $team['name'];
        $team_id = $team['id'];
    }

    $players = json_decode(getPlayers($team_id), true);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include("inc/head.php"); ?>
        <script>
            var teamId = <?php echo $team_id; ?>;
        </script>
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
                    <ul id="playerList" class="tabList">
                       <?php
                            foreach ($players as $player) {
                                $player_id = $player['id'];
                                $player_f_name = $player['first_name'];
                                $player_l_name = $player['last_name'];
                                echo '<li value="' . $player_id . '">' . $player_f_name . ' ' . $player_l_name.'</li>';
                            }
                        ?>
                        <li><i class="fa fa-plus" aria-hidden="true"></i><a class="callInput" id="playerTabAdd" href="#">Add Player</a></li>
                    </ul>
                    <form class="popUpWindow" id="addPlayerForm">
                        <label for="pFName">First name </label>
                        <input type="text" id="pFName" name="pFName" />
                        <br />
                        <label for="pLName">Last name </label>
                        <input type="text" id="pLName" name="pLName" />
                        <input class="close" type="submit" value="Submit">
                        <div id="playerMsgDiv" class="err"></div>
                    </form>
                </div>

                <div id="positionTab" class="panel">
                    <ul id="positionList" class="tabList">
                        <?php
                            $positions = json_decode(getPositions(), true);
                            foreach ($positions as $position) {
                                echo "<li value='" . $position['id'] . "'>" . $position['name'] ."</li>";
                            }
                        ?>
                        <li><i class="fa fa-plus" aria-hidden="true"></i><a class="callInput" id="positionTabAdd">Add Position</a></li>
                    </ul>
                    <form class="popUpWindow" id="addPositionForm">
                        <label for="position">Position </label>
                        <input type="text" id="position" name="position" />
                        <input class="close" type="submit" value="Submit">
                        <div id="positionMsgDiv" class="err"></div>
                    </form>
                </div>

                <div id="gameTab" class="panel">
                    <ul id="gameList" class="tabList">
                        <?php
                            $games = json_decode(getGames(), true);
                            foreach ($games as $game) {
                                //echo "<li value='" . $game['id'] . "'>" . $game['game_name'] ."</li>";
                                echo "<li value='" . $game['id'] . "'><input type='radio' name='gameIndx' value='" . $game['id'] . "' class='rdoGame' />" . $game['game_name'] . "</li>";
                            }
                        ?>
                        <li><i class="fa fa-plus" aria-hidden="true"></i><a id="gameTabAdd" class="callInput">Add Game</a></li>
                    </ul>
                    <form class="popUpWindow" id="addGameForm">
                        <label for="game">Add Game: </label>
                        <input type="text" id="game" name="game" />
                        <input class="close" type="submit" value="Submit">
                        <div id="gameMsgDiv" class="err"></div>
                    </form>
                    <button class="generate" id="generateLineup">Generate Line-up</button>
                </div>
            </div>
            <!-- End tabs -->
        </div>

        <?php include("inc/scripts.php"); ?>
        <script src="js/manage_team_scripts.js"></script>
    </body>
</html>
