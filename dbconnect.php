<?php
//connection to database nursing
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nursing";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 
else {
 // echo "Connected successfully";
}
?>