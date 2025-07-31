<?php
include 'session.php'; // Ensure user is logged in
include 'dbconnect.php'; // include your database connection

//error_reporting(E_ALL);
error_reporting(E_ALL);
ini_set('display_errors', 0);// Set to 1 to display errors, 0 to hide them


// Check if the request method is POST
// This ensures that the form is submitted correctly

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data safely
    $test_date     = $_POST['testDate'];
    $cd4_count     = $_POST['cd4Count'];
    $cd4_perc      = $_POST['cd4Perc'];
    $viral_load    = $_POST['viralLoad'];
    $hb            = $_POST['hb'];
    $ast           = $_POST['ast'];
    $alt           = $_POST['alt'];
    $trigly        = $_POST['trigly'];
    $cholest       = $_POST['cholest'];
    $ldl           = $_POST['ldl'];
    $hdl           = $_POST['hdl'];
    $creat         = $_POST['creat'];

    // Prepare and bind statement
    $stmt = $conn->prepare("INSERT INTO laboratory_results (
        test_date, cd4_count, cd4_perc, viral_load, hb, ast, alt,
        total_trigly, total_cholest, ldl, hdl, creat
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
        "sididiiiiiid",
        $test_date,
        $cd4_count,
        $cd4_perc,
        $viral_load,
        $hb,
        $ast,
        $alt,
        $trigly,
        $cholest,
        $ldl,
        $hdl,
        $creat
    );

    // Execute and respond
    if ($stmt->execute()) {
        echo "✅ Laboratory results saved successfully.";
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} 

?>

<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'; ?>
<body>
  <div class="form-container">
    <h1 class="form-title">Laboratory Results Form</h1>
    <form action="laboratory.php" method="post">
      
      <div class="form-group">
        <label for="testDate">Test Date</label>
        <input type="date" id="testDate" name="testDate" class="form-control">
      </div>

      <div class="form-group">
        <label for="cd4Count">CD4 Count</label>
        <input type="number" id="cd4Count" name="cd4Count" class="form-control">
      </div>

      <div class="form-group">
        <label for="cd4Perc">CD4 Percentage</label>
        <input type="number" step="0.1" id="cd4Perc" name="cd4Perc" class="form-control">
      </div>

      <div class="form-group">
        <label for="viralLoad">Viral Load</label>
        <input type="number" id="viralLoad" name="viralLoad" class="form-control">
      </div>

      <div class="form-group">
        <label for="hb">HB</label>
        <input type="number" step="0.1" id="hb" name="hb" class="form-control">
      </div>

      <div class="form-group">
        <label for="ast">AST</label>
        <input type="number" id="ast" name="ast" class="form-control">
      </div>

      <div class="form-group">
        <label for="alt">ALT</label>
        <input type="number" id="alt" name="alt" class="form-control">
      </div>

      <div class="form-group">
        <label for="trigly">Total Triglycerides</label>
        <input type="number" id="trigly" name="trigly" class="form-control">
      </div>

      <div class="form-group">
        <label for="cholest">Total Cholesterol</label>
        <input type="number" id="cholest" name="cholest" class="form-control">
      </div>

      <div class="form-group">
        <label for="ldl">LDL</label>
        <input type="number" id="ldl" name="ldl" class="form-control">
      </div>

      <div class="form-group">
        <label for="hdl">HDL</label>
        <input type="number" id="hdl" name="hdl" class="form-control">
      </div>

      <div class="form-group">
        <label for="creat">Creatinine</label>
        <input type="number" id="creat" name="creat" class="form-control">
      </div>

      <button type="submit" class="btn btn-primary">Submit Results</button>
    </form>
  </div>
</body>
</html>
