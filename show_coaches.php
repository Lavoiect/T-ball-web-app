<?php
    session_start();
    $auth = $_SESSION["auth"];
    $coach = $_SESSION["coach"];

    if (!$auth) {
        header("Location: login.php");
    }

    include 'inc/db.php';
    include 'inc/db_coach.php';
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

           <h2 class="dataList headLines">Coaches</h2>
            <div class="dataList">
                <ul>
                    <?php
                        $coaches = json_decode(getCoaches(), true);
                        foreach ($coaches as $coach) {
                            echo "<li value='" . $coach['id'] . "'>" . $coach['user_name'] . ": " . $coach['first_name'] . " " . $coach['last_name'] . "<a href='mailto:" . $coach['email'] . "'><i class='fa fa-envelope' aria-hidden='true'></i></a></li>";
                        }
                    ?>
                </ul>
            </div>
        </div>

        <?php include("inc/scripts.php"); ?>
    </body>
</html>
