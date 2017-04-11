<?php
    session_start();
    $auth = $_SESSION["auth"];
    $coach = $_SESSION["coach"];
    $coach_id = $_SESSION["coach_id"];

    include 'inc/db.php';
    include 'inc/db_game.php';

    error_reporting(E_ALL);
    ini_set("display_errors","On");

    if (!$auth) {
        header("Location: login.php");
    }

    $q_game_id = $_GET["game_id"];
    
    if ($q_game_id == '') {
        header("Location: error.php");
    } else {
        $game_data = getGameData($q_game_id);
        $game_data_json = json_decode($game_data, true);
        
        $first_inning_roster = array();
        $second_inning_roster = array();
        $third_inning_roster = array();
        
        foreach($game_data_json as $item) { //foreach element in $arr
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
            } 
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head></head>
    <body>
        <h1>Team: <?php echo getTeamNameForGame($q_game_id) ?></h1>
        <h2>Game: <?php echo getGameName($q_game_id) ?></h2>

        <h3>First Inning</h3>
        <table border="1">
            <thead>
                <tr>
                    <th>Position</th>
                    <th>Player</th>
                </tr>
            </thead>
            <tbody id="firstInning">
                <?php
                    foreach($first_inning_roster as $item) {
                        echo "<tr>";
                        echo "<td>" . $item['name'] . "</td>";
                        echo "<td>" . $item['first_name'] . " " . $item['last_name'] . "</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table> 

        <h3>Second Inning</h3>
        <table border="1">
            <thead>
                <tr>
                    <th>Player</th>
                    <th>Position</th>
                </tr>
            </thead>
            <tbody id="secondInning">
                <?php
                    foreach($second_inning_roster as $item) {
                        echo "<tr>";
                        echo "<td>" . $item['name'] . "</td>";
                        echo "<td>" . $item['first_name'] . " " . $item['last_name'] . "</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table> 

        <h3>Third Inning</h3>
        <table border="1">
            <thead>
                <tr>
                    <th>Player</th>
                    <th>Position</th>
                </tr>
            </thead>
            <tbody id="thirdInning">
                <?php
                    foreach($third_inning_roster as $item) {
                        echo "<tr>";
                        echo "<td>" . $item['name'] . "</td>";
                        echo "<td>" . $item['first_name'] . " " . $item['last_name'] . "</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>    
    </body>
</html>
