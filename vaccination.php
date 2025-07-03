<?php
include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vaccine_no = $_POST['vaccine_no'];
    $vaccine = $_POST['vaccine'];
    $date_given = $_POST['date_given'];

    $stmt = $conn->prepare("INSERT INTO vaccination (vaccine_no, vaccine, date_given) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $vaccine_no, $vaccine, $date_given);

    if ($stmt->execute()) {
        echo "✅ Vaccination record saved successfully.";
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
  <title>Vaccination Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #eef3f9;
      padding: 40px;
    }

    .form-container {
      max-width: 500px;
      margin: auto;
      background-color: #fff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
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
    input[type="date"] {
      width: 100%;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #007BFF;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
    }

    button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

<div class="form-container">
  <h2>Vaccination Form</h2>
  <form action="vaccination.php" method="post">
    <div class="form-group">
      <label for="vaccine_no">Vaccine No</label>
      <input type="text" id="vaccine_no" name="vaccine_no" required>
    </div>

    <div class="form-group">
      <label for="vaccine">Vaccine</label>
      <input type="text" id="vaccine" name="vaccine" required>
    </div>

    <div class="form-group">
      <label for="date_given">Date Given</label>
      <input type="date" id="date_given" name="date_given" required>
    </div>

    <button type="submit">Submit Vaccination</button>
  </form>
</div>

</body>
</html>
