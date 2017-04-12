<?php
    session_start();
    $auth = $_SESSION["auth"];
    $coach = $_SESSION["coach"];
    $coach_id = $_SESSION["coach_id"];

    include 'inc/db.php';
    include 'inc/db_game.php';

    //error_reporting(E_ALL);
    //ini_set("display_errors","On");

    if (!$auth) {
        header("Location: login.php");
    }

    $q_game_id = $_GET["game_id"];
    
    if ($q_game_id == '') {
        header("Location: error.php");
    } else {
        $game_data = getGameData($q_game_id);
        $game_data_json = json_decode($game_data, true);
        
        $innings = array();
        $first_inning_roster   = array();
        $second_inning_roster  = array();
        $third_inning_roster   = array();
        $fourth_inning_roster  = array();
        $fifth_inning_roster   = array();
        $sixth_inning_roster   = array();
        $seventh_inning_roster = array();
        $eighth_inning_roster  = array();
        $ninth_inning_roster   = array();
        
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
                case 6:
                    $sixth_inning_roster[] = $item;
                    break;
                case 7:
                    $seventh_inning_roster[] = $item;
                    break;
                case 8:
                    $eighth_inning_roster[] = $item;
                    break;
                case 9:
                    $ninth_inning_roster[] = $item;
                    break;
            } 
        }
        
        $innings[] = $first_inning_roster;
        $innings[] = $second_inning_roster;
        $innings[] = $third_inning_roster;
        $innings[] = $fourth_inning_roster;
        $innings[] = $fifth_inning_roster;
        $innings[] = $sixth_inning_roster;
        $innings[] = $seventh_inning_roster;
        $innings[] = $eighth_inning_roster;
        $innings[] = $ninth_inning_roster;
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head></head>
    <body>
        <h1>Team: <?php echo getTeamNameForGame($q_game_id) ?></h1>
        <h2>Game: <?php echo getGameName($q_game_id) ?></h2>

       <?php    
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
        ?>
    </body>
</html>
