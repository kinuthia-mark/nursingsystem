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
<html>
<?php include 'head.php'; ?>

<body>
  <div class="form-container">
    <h1 class="form-title" style="text-align: center;">Add Vaccine Name</h1>
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
