<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nursing";

$conn = new mysqli($servername, $username, $password, $dbname);
$username = "admin_temp";
$password = "admin123";

$hash = password_hash($password, PASSWORD_BCRYPT);

$stmt = $conn->prepare(
    "INSERT INTO users (username, password) VALUES (?, ?)"
);
$stmt->bind_param("ss", $username, $hash);
$stmt->execute();

echo "User created successfully<br>";
echo "Hash: " . $hash;
