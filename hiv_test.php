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
<?php include 'head.php'; ?>
<body>

  <div class="form-container">
    <h1 class="form-title" style="text-align: center;">HIV Test Form</h1>

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
        <select id="result" name="result" required>
          <option value="">Select Result</option>
          <option value="Positive">Positive</option>
          <option value="Negative">Negative</option>
          <option value="unknown">Unknown</option>
        </select> 
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
