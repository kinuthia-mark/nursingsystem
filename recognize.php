<?php
// recognize.php

// 1. Force the ID to be an integer
$child_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$patient_banner = ""; // Initialize as empty

if ($child_id > 0) {
    // 2. Fetch data
    $stmt = $conn->prepare("SELECT name, age, gender, status FROM children WHERE id = ?");
    $stmt->bind_param("i", $child_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $child_name = htmlspecialchars($row['name']);
        $child_age = htmlspecialchars($row['age']);
        $child_gender = htmlspecialchars($row['gender']);
        $child_status = strtoupper($row['status']);

        // Determine Color
        $status_color = ($child_status == 'CRITICAL') ? '#f1416c' : (($child_status == 'OBSERVATION') ? '#ffc700' : '#50cd89');

        // 3. Build the Banner String
        $patient_banner = '
        <div class="patient-banner" style="background:#fff; border-left:5px solid '.$status_color.'; padding:15px; border-radius:10px; box-shadow:0 2px 10px rgba(0,0,0,0.05); margin-bottom:20px; display:flex; justify-content:space-between; align-items:center;">
            <div>
                <h4 style="margin:0; color:#333;">'.$child_name.'</h4>
                <small style="color:#777;">ID: #C-'.str_pad($child_id, 3, '0', STR_PAD_LEFT).' | Age: '.$child_age.' | Gender: '.$child_gender.'</small>
            </div>
            <span style="background:'.$status_color.'; color:#fff; padding:4px 12px; border-radius:15px; font-size:11px; font-weight:700;">'.$child_status.'</span>
        </div>';
    } else {
        // This triggers if ID=1 exists in URL but NOT in the database
        $patient_banner = '<div class="alert alert-danger">Patient ID #'.$child_id.' not found in registry.</div>';
    }
} else {
    // This triggers if ID is missing or 0
    $patient_banner = '<div class="alert alert-warning">No patient selected. Please select from Master Registry.</div>';
}
?>