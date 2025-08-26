<?php
// Start session safely
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'dbconnect.php';

// Redirect if user not logged in
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
