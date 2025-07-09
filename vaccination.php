<?php
include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vaccine_no = $_POST['vaccine_no'];
    $vaccine = $_POST['vaccine'];
    $date_given = $_POST['date_given'];

    $stmt = $conn->prepare("INSERT INTO vaccination (vaccine_no, vaccine, date_given) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $vaccine_no, $vaccine, $date_given);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>✅ Vaccination record saved successfully.</p>";
    } else {
        echo "<p style='color: red;'>❌ Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// ✅ Get vaccine list from DB
$vaccineOptions = "";
$result = $conn->query("SELECT vaccine_name FROM vaccine_list ORDER BY vaccine_name ASC");
while ($row = $result->fetch_assoc()) {
    $vaccine = htmlspecialchars($row['vaccine_name']);
    $vaccineOptions .= "<option value=\"$vaccine\">$vaccine</option>";
}
$conn->close();
?>

<!DOCTYPE html>
<html>
  <?php include 'head.php'; ?>
<body>

<div class="form-container">
<h1 class="form-title" style="text-align: center;">Vaccination Form</h1>
  <div class="top-right-link">
    <a href="add_vaccine.php" target="_blank">➕ Add New Vaccine</a>
  </div>

  <form action="vaccination.php" method="post">
    <div class="form-group">
      <label for="vaccine_no">Vaccine No</label>
      <input type="text" id="vaccine_no" name="vaccine_no" required>
    </div>

    <div class="form-group">
      <label for="vaccine">Vaccine</label>
      <select id="vaccine" name="vaccine" required>
        <option value="">-- Select Vaccine --</option>
        <?= $vaccineOptions ?>
      </select>
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
