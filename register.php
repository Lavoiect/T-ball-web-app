<?php
    session_start();
    $auth = $_SESSION["auth"];

    $q_id = $_GET["id"];
    $q_auth = $_GET["auth"];

    include 'inc/db.php';
    include 'inc/db_user.php';

    if ($auth) {
        header("Location: index.php");
    }

    $msg ="";
    $frm_f_name = "";
    $frm_l_name = "";
    $frm_email = "";
    $frm_user_name = "";

    if (count($_POST) > 0) {
        $frm_f_name = $_POST["fName"];
        $frm_l_name = $_POST["lName"];
        $frm_email = $_POST["email"];
        $frm_user_name = $_POST["userName"];
        
        $q_id = $_POST["qId"];
        $q_auth = $_POST["qAuth"];
        
        if ($q_id == "" && $q_auth == "") {
            $msg = "Please contact the site Admin to register.";
        } else {
            $f_name = $_POST["fName"];
            $l_name = $_POST["lName"];
            $email = $_POST["email"];
            $user_name = $_POST["userName"];
            $pwd = $_POST["password"];

            if ($f_name != "" && $l_name != "" && $email != "" && $user_name != "" && $pwd != "") {
                $success = register($f_name, $l_name, $email, $user_name, $pwd, $q_id, $q_auth);

                if ($success == "success") {
                    header("Location: login.php");
                } else {
                    $msg = $success;
                }
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
        
            <form id="regForm" action="register.php" method="POST">
                <label for="fName">First Name:</label>
                <input id="fName" name="fName" type="text" value="<?php echo $frm_f_name ?>" required="required" autofocus="autofocus" /><br />               
                <label for="lName">Last Name:</label>
                <input id="lName" name="lName" type="text" value="<?php echo $frm_l_name ?>" required="required" /><br />               
                <label for="email">Email:</label>
                <input id="email" name="email" type="email" value="<?php echo $frm_email ?>" required="required" /><br /> 

                <hr />
                
                <label for="userName">User Name:</label>
                <input id="userName" name="userName" type="text" value="<?php echo $frm_user_name ?>" required="required" /><br />
                <label for="password">Password:</label>
                <input id="password" name="password" type="password" required="required" /><br />
                <label for="confirm">Confirm:</label>
                <input id="confirm" type="password" required="required" /><br />
                
                <?php if($q_id != "" && $q_auth != "") : ?>
                    <input type="hidden" name="qId" id="qId" value="<?php echo $q_id ?>" />
                    <input type="hidden" name="qAuth" id="qAuth" value="<?php echo $q_auth ?>" />
                <?php endif; ?>
                
                <button class="submit" type="submit">Register</button>
            </form>  

            <div id="msgDiv" class="err"></div>
            
            <?php if($msg != "") : ?>
                <div class="err">Error: <?php echo $msg ?></div>
            <?php endif; ?>
        </div>
        
        <?php include("inc/scripts.php"); ?>
        <script src="scripts/register_scripts.js"></script>
    </body>
</html>