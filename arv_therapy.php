<?php
// session.php
include 'session.php';
// dbconnect.php
include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $drug1 = $_POST['drug_1'];
    $drug2 = $_POST['drug_2'];
    $drug3 = $_POST['drug_3'];
    $date_started = $_POST['date_started'];
    $date_stopped = $_POST['date_stopped'];
    $reason = $_POST['reason'];
    $regimen = $_POST['regimen'];

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

<?php
include 'dbconnect.php';
$drugOptions = "";
$result = $conn->query("SELECT drug_name FROM drug_list ORDER BY drug_name ASC");
while ($row = $result->fetch_assoc()) {
    $drug = htmlspecialchars($row['drug_name']);
    $drugOptions .= "<option value=\"$drug\">$drug</option>";
}
?>

<!DOCTYPE html>
<html>
<?php include 'head.php'; ?>
<body>
<?php include 'sidenav.php'; ?>
  <div class="form-container">
    <h1 class="form-title" style="text-align: center;">ARV Therapy Form</h1>

    <div class="top-right-link">
      <a href="add_drug.php" target="_blank">➕ Add New Drug</a>
    </div>

    <form action="arv_therapy.php" method="post">
      
      <div class="form-group">
        <label for="drug_1">Drug 1</label>
        <select name="drug_1" id="drug_1" required>
          <option value="">-- Select Drug --</option>
          <?= $drugOptions ?>
        </select>
      </div>

      <div class="form-group">
        <label for="drug_2">Drug 2</label>
        <select name="drug_2" id="drug_2" required>
          <option value="">-- Select Drug --</option>
          <?= $drugOptions ?>
        </select>
      </div>

      <div class="form-group">
        <label for="drug_3">Drug 3</label>
        <select name="drug_3" id="drug_3" required>
          <option value="">-- Select Drug --</option>
          <?= $drugOptions ?>
        </select>
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
