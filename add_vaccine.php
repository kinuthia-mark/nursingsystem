<?php
include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vaccine_name = trim($_POST['vaccine_name']);

    if (!empty($vaccine_name)) {
        $stmt = $conn->prepare("INSERT INTO vaccine_list (vaccine_name) VALUES (?)");
        $stmt->bind_param("s", $vaccine_name);

        if ($stmt->execute()) {
            echo "✅ Vaccine added successfully.";
        } else {
            echo "❌ Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "❗ Vaccine name is required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Vaccine</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f6fa;
      padding: 40px;
    }
    .form-container {
      max-width: 400px;
      margin: auto;
      background: #fff;
      padding: 25px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    h3 {
      text-align: center;
      margin-bottom: 20px;
    }
    .form-group {
      margin-bottom: 15px;
    }
    label, input {
      display: block;
      width: 100%;
    }
    input[type="text"] {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    button {
      padding: 10px;
      width: 100%;
      background: #007BFF;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
    button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h3>Add Vaccine Name</h3>
    <form action="" method="post">
      <div class="form-group">
        <label for="vaccine_name">Vaccine Name</label>
        <input type="text" name="vaccine_name" required>
      </div>
      <button type="submit">Add Vaccine</button>
    </form>
  </div>
</body>
</html>
