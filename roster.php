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
    $have_existing_data = true;
    
    if ($q_game_id == '') {
        header("Location: error.php");
    } else {
        $game_data = getGameData($q_game_id);
        $game_data_json = json_decode($game_data, true);
        if (sizeof($game_data_json) == 0) {
            $have_existing_data = false;
        } else { 
           $innings = array();
            $first_inning_roster   = array();
            $second_inning_roster  = array();
            $third_inning_roster   = array();
            $fourth_inning_roster  = array();
            $fifth_inning_roster   = array();

            foreach($game_data_json as $item) {
                switch ($item['inning']) {
                    case 1:
                        $first_inning_roster[] = $item;
                        break;
                    case 2:
                        $second_inning_roster[] = $item;
                        break;
                    case 3:
                        $third_inning_roster[] = $item;
                        break;
                    case 4:
                        $fourth_inning_roster[] = $item;
                        break;
                    case 5:
                        $fifth_inning_roster[] = $item;
                        break;
                } 
            }

            $innings[] = $first_inning_roster;
            $innings[] = $second_inning_roster;
            $innings[] = $third_inning_roster;
            $innings[] = $fourth_inning_roster;
            $innings[] = $fifth_inning_roster;
        }
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

        <?php if (! $have_existing_data) { ?>
            <form id="rosterForm">
                <label for="nbrOfInnings">Number of Innings </label>
                <br /><select id="nbrOfInnings" autofocus="autofocus">
                    <option value="0">Select Number of Innings</option>
                    <option value="3">3</option>
                    <option value="5">5</option>
                </select>
                <br /><button class="submit" type="submit">Generate Line-up</button>
            </form>
            <div id="msgDiv" class="err"></div>
        
            <div id="rosterDiv"></div>
        <?php } else { 
                    foreach($innings as $key=>$value) {
                        $inning_no = ($key + 1);
                        $roster_size = sizeof($value);

                        if ($roster_size > 0) {
                            echo '<h3>Inning ' . $inning_no . '</h3>';
                            echo '<table border="1">';
                                echo '<thead>';
                                    echo '<tr>';
                                        echo '<th>Position</th>';
                                        echo '<th>Player</th>';
                                    echo '</tr>';
                                echo '</thead>';
                                echo '<tbody id="inning' . $inning_no . '">';

                                foreach($value as $item) {
                                    echo "<tr>";
                                    echo "<td>" . $item['name'] . "</td>";
                                    echo "<td>" . $item['first_name'] . " " . $item['last_name'] . "</td>";
                                    echo "</tr>";
                                }

                                echo '</tbody>';
                            echo '</table>';
                        }
                    }
            }
        ?>
        
       
        <?php include("inc/scripts.php"); ?>
        <script src="js/roster_scripts.js"></script>
    </body>
</html>
