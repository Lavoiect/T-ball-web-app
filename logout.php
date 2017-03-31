<?php
    session_start();
    $_SESSION["auth"] = false;
    $_SESSION["coach"] = $_POST[""];
    header("Location: index.php");
?>
