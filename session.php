<?php
//session start

session_start();
include 'dbconnect.php';
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

?>