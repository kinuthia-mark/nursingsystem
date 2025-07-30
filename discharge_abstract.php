<?php
//include 'db_connection.php'; // Include your database connection file
include 'dbconnect.php'; 

//handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $discharge_date = $_POST['discharge_date'];
    $discharge_weight = $_POST['discharge_weight'];
    $discharge_height = $_POST['discharge_height'];
    $adherence = $_POST['adherence'];
    $ccc_name = $_POST['ccc_name'];
    $discharge_doctor = $_POST['discharge_doctor'];
    $admission = $_POST['admission'];
    $clinical_progress = $_POST['clinical_progress'];
    $condition_at_discharge = $_POST['condition_at_discharge'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO discharge_abstract (discharge_date, discharge_weight, discharge_height, adherence, ccc_name, discharge_doctor, admission, clinical_progress, condition_at_discharge) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sddssssss", $discharge_date, $discharge_weight, $discharge_height, $adherence, $ccc_name, $discharge_doctor, $admission, $clinical_progress, $condition_at_discharge);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}

?>

<!DOCTYPE html>
<?php include 'head.php'; ?>
<body>
   <form action="discharge_abstract.php" method="POST">
  <section class="form-container">
    <h1 class="form-title">Discharge Abstract</h1>

    <div class="form-grid">
      <div>
        <label for="discharge_date">Discharge Date:</label>
        <input type="date" id="discharge_date" name="discharge_date" required>
      </div>

      <div>
        <label for="discharge_weight">Discharge Weight (Kg):</label>
        <input type="number" id="discharge_weight" name="discharge_weight" step="0.1" required>
      </div>

      <div>
        <label for="discharge_height">Discharge Height (cm):</label>
        <input type="number" id="discharge_height" name="discharge_height" step="0.1" required>
      </div>

      <div>
        <label for="adherence">Adherence:</label>
        <input type="text" id="adherence" name="adherence" required>
      </div>

      <div>
        <label for="ccc_name">Name of CCC:</label>
        <input type="text" id="ccc_name" name="ccc_name" required>
      </div>

      <div>
        <label for="discharge_doctor">Discharge Doctor:</label>
        <input type="text" id="discharge_doctor" name="discharge_doctor" required>
      </div>

      <div>
        <label for="admission">Admission:</label>
        <textarea id="admission" name="admission" rows="4" required></textarea>
      </div>

      <div>
        <label for="clinical_progress">Clinical Progress:</label>
        <textarea id="clinical_progress" name="clinical_progress" rows="4" required></textarea>
      </div>

      <div>
        <label for="condition_at_discharge">Condition at Discharge:</label>
        <textarea id="condition_at_discharge" name="condition_at_discharge" rows="4" required></textarea>
      </div>

      
    </div>
    <button type="submit">Submit</button>
  </section>
</form>

</body>
</html>
