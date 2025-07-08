<?php
include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $drug_name = trim($_POST['drug_name']);

    if (!empty($drug_name)) {
        $stmt = $conn->prepare("INSERT INTO drug_list (drug_name) VALUES (?)");
        $stmt->bind_param("s", $drug_name);

        if ($stmt->execute()) {
            echo "✅ Drug added successfully.";
        } else {
            echo "❌ Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "❗ Drug name cannot be empty.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Drug</title>
  <style>
    body { font-family: Arial; padding: 30px; background: #f7f9fc; }
    .form-container {
      max-width: 400px;
      margin: auto;
      background: white;
      padding: 25px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    label, input, button { width: 100%; margin-top: 10px; }
    button {
      background: #28a745;
      color: white;
      border: none;
      padding: 10px;
      border-radius: 6px;
      cursor: pointer;
    }
    button:hover { background: #218838; }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Add New Drug</h2>
    <form method="post">
      <label>Drug Name</label>
      <input type="text" name="drug_name" required>
      <button type="submit">Add Drug</button>
    </form>
  </div>
</body>
</html>
