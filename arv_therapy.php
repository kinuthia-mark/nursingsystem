<?php
include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $drug1        = $_POST['drug_1'];
    $drug2        = $_POST['drug_2'];
    $drug3        = $_POST['drug_3'];
    $date_started = $_POST['date_started'];
    $date_stopped = $_POST['date_stopped'];
    $reason       = $_POST['reason'];
    $regimen      = $_POST['regimen'];

    $stmt = $conn->prepare("INSERT INTO arv_therapy 
        (drug_1, drug_2, drug_3, date_started, date_stopped, reason, regimen) 
        VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $drug1, $drug2, $drug3, $date_started, $date_stopped, $reason, $regimen);

    if ($stmt->execute()) {
        echo "✅ ARV Therapy data saved successfully.";
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ARV Therapy Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #eef2f7;
      padding: 40px;
    }

    .form-container {
      max-width: 600px;
      margin: auto;
      background-color: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }

    .form-group {
      margin-bottom: 15px;
    }

    label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
    }

    input[type="text"],
    input[type="date"],
    textarea {
      width: 100%;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }

    textarea {
      resize: vertical;
      height: 80px;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #28a745;
      color: white;
      font-size: 16px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    button:hover {
      background-color: #218838;
    }
  </style>
</head>
<body>

  <div class="form-container">
    <h2>ARV Therapy Form</h2>
    <form action="arv_therapy.php" method="post">
      <div class="form-group">
        <label for="drug_1">Drug 1</label>
        <input type="text" id="drug_1" name="drug_1" required>
      </div>

      <div class="form-group">
        <label for="drug_2">Drug 2</label>
        <input type="text" id="drug_2" name="drug_2" required>
      </div>

      <div class="form-group">
        <label for="drug_3">Drug 3</label>
        <input type="text" id="drug_3" name="drug_3" required>
      </div>

      <div class="form-group">
        <label for="date_started">Date Started</label>
        <input type="date" id="date_started" name="date_started" required>
      </div>

      <div class="form-group">
        <label for="date_stopped">Date Stopped</label>
        <input type="date" id="date_stopped" name="date_stopped">
      </div>

      <div class="form-group">
        <label for="reason">Reason for Stopping</label>
        <textarea id="reason" name="reason"></textarea>
      </div>

      <div class="form-group">
        <label for="regimen">Regimen</label>
        <input type="text" id="regimen" name="regimen" required>
      </div>

      <button type="submit">Submit ARV Therapy</button>
    </form>
  </div>

</body>
</html>
