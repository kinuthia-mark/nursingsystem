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
<?php include 'head.php'; ?>
<body>
  <div class="form-container">
    <h1 class="form-title" style="text-align: center;">Add New Drug</h1>

    <form method="post">
      <label>Drug Name</label>
      <input type="text" name="drug_name" required>
      <button type="submit">Add Drug</button>
    </form>
  </div>
</body>
</html>
