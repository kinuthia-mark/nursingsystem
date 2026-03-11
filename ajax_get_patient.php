<?php
require_once 'dbconnect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Ensure these column names match your 'patients' table
    $stmt = $conn->prepare("SELECT id, first_name, last_name, dob, gender, school, current_regimen, arv_start_date FROM patients WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}