<?php
// Database configuration
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "nursing";

// Enable mysqli exception reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // 1. Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 2. Set charset to utf8mb4 (Supports all characters/emojis)
    $conn->set_charset("utf8mb4");

    // 3. Set Timezone (Adjust 'Africa/Nairobi' to your local zone)
    date_default_timezone_set('Africa/Nairobi');
    $conn->query("SET time_zone = '+03:00'");

} catch (mysqli_sql_exception $e) {
    error_log($e->getMessage());
    die("🏥 System Connection Error: Please contact the administrator.");
}
?>