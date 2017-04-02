<?php
    session_start();
    $auth = $_SESSION["auth"];

    include 'inc/db.php';
    include 'inc/db_user.php';

    if ($auth) {
        header("Location: index.php");
    }

    $valid = true;

    if (count($_POST) > 0) {
        $user_name = $_POST["userName"];
        $pwd = $_POST["password"];

        if ($user_name != "" && $pwd != "") {
            $success = login($user_name, $pwd);

            if ($success) {
                $_SESSION["auth"] = true;
                $_SESSION["coach"] = getUserName($user_name);
                $_SESSION["coach_id"] = getUserId($user_name);
                
                if ($user_name == "Admin") {
                    header("Location: add_coach.php");
                } else {
                    header("Location: add_team.php");
                }
            } else {
                $valid = false;
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
            </div>
            <!-- End nav div-->
        
            <form id="loginForm" action="login.php" method="POST">
                <label for="userName">User Name:</label>
                <input id="userName" name="userName" type="text" value="<?php echo $user_name ?>" required="required" autofocus="autofocus" /><br />
                <label for="password">Password:</label>
                <input id="password" name="password" type="password" required="required" /><br />
                
                <label for="rememberMe">Remember Me:</label>
                <input type="checkbox" id="rememberMe" /><br />
                
                <button type="submit">Login</button>
            </form>  

            <?php if(! $valid) : ?>
                <div class="err">Error: Please check your credentials.</div>
            <?php endif; ?>
        </div>
        
        <?php include("inc/scripts.php"); ?>
        <script src="scripts/login_scripts.js"></script>
    </body>
</html>