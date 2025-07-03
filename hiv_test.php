<?php
include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $test_no     = $_POST['test_no'];
    $date_tested = $_POST['date_tested'];
    $age         = $_POST['age'];
    $result      = $_POST['result'];
    $agency      = $_POST['agency'];

    $stmt = $conn->prepare("INSERT INTO hiv_test (test_no, date_tested, age, result, agency)
                            VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $test_no, $date_tested, $age, $result, $agency);

    if ($stmt->execute()) {
        echo "✅ HIV test record saved successfully.";
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
  <title>HIV Test Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
      padding: 40px;
    }

    .form-container {
      max-width: 500px;
      margin: auto;
      background-color: #fff;
      padding: 25px;
      border-radius: 10px;
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
      margin-bottom: 6px;
    }

    input[type="text"],
    input[type="date"],
    input[type="number"] {
      width: 100%;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
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
    <h2>HIV Test Form</h2>
    <form action="hiv_test.php" method="post">
      <div class="form-group">
        <label for="test_no">Test Number</label>
        <input type="text" id="test_no" name="test_no" required>
      </div>

      <div class="form-group">
        <label for="date_tested">Date Tested</label>
        <input type="date" id="date_tested" name="date_tested" required>
      </div>

      <div class="form-group">
        <label for="age">Age</label>
        <input type="number" id="age" name="age" required>
      </div>

      <div class="form-group">
        <label for="result">Result</label>
        <input type="text" id="result" name="result" placeholder="Positive / Negative" required>
      </div>

      <div class="form-group">
        <label for="agency">Agency</label>
        <input type="text" id="agency" name="agency" required>
      </div>

      <button type="submit">Submit Test</button>
    </form>
  </div>

</body>
</html>
