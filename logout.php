<?php
//destroy session and redirect to login page
session_destroy();
header("Location: login.php");
?>