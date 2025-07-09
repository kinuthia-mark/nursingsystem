<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//include database connection
include 'dbconnect.php';

//handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_date = $_POST['input_date'];
    $history = $_POST['history'];
    $WT = $_POST['WT'];
    $HT = $_POST['HT'];
    $HC = $_POST['HC'];
    $Temp = $_POST['Temp'];
    $diagnosis = $_POST['diagnosis'];
    $plan = $_POST['plan'];

    $stmt = $conn->prepare("INSERT INTO progress_notes 
    (input_date, history, WT, HT, HC, Temp, diagnosis, plan)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt) {
        // If your DB columns for WT, HT, HC, Temp are DECIMAL/FLOAT
        $stmt->bind_param("ssddddss", $input_date, $history, $WT, $HT, $HC, $Temp, $diagnosis, $plan);
        if ($stmt->execute()) {
            echo "<p style='color:green;'>✅ Saved successfully</p>";
        } else {
            echo "Error executing: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Prepare failed: " . $conn->error;
    }
}

?>

<!DOCTYPE html>

<?php include 'head.php'; ?>

<body>
    <form method="POST" action="" class="form-container">
  <section>
    <h1 class="form-title">Progress Notes</h1>

    <div class="form-grid">
      <div class="form-group">
        <label for="input_date">Input Date:</label>
        <input type="date" id="input_date" name="input_date" required>
      </div>

      <div class="form-group form-group-full">
        <label for="history">History:</label>
        <textarea id="history" name="history" rows="6" placeholder="Enter history" required></textarea>
      </div>

      <div class="form-group">
        <label for="WT">WT (kg):</label>
        <input type="number" step="0.01" id="WT" name="WT" placeholder="Enter weight" required>
      </div>

      <div class="form-group">
        <label for="HT">HT (cm):</label>
        <input type="number" step="0.01" id="HT" name="HT" placeholder="Enter height" required>
      </div>

      <div class="form-group">
        <label for="HC">HC (cm):</label>
        <input type="number" step="0.01" id="HC" name="HC" placeholder="Enter head circumference" required>
      </div>

      <div class="form-group">
        <label for="Temp">Temp (°C):</label>
        <input type="number" step="0.01" id="Temp" name="Temp" placeholder="Enter temperature" required>
      </div>

      <div class="form-group form-group-full">
        <label for="diagnosis">Diagnosis:</label>
        <textarea id="diagnosis" name="diagnosis" rows="4" placeholder="Enter diagnosis" required></textarea>
      </div>

      <div class="form-group form-group-full">
        <label for="plan">Plan:</label>
        <textarea id="plan" name="plan" rows="6" placeholder="Enter plan" required></textarea>
      </div>

    </div>

    <button type="submit">Submit</button>
  </section>
</form>

</body>
</html>
