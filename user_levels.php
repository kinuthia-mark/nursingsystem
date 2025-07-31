<?php 
//ERROR REPORTING
error_reporting(E_ALL);
ini_set('display_errors', 1);
// session.php
include 'session.php';
// dbconnect.php  
include 'dbconnect.php';

//SUBMIT FORM
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $levelName = $_POST["levelName"];

  // Prepare and bind
  $stmt = $conn->prepare("INSERT INTO user_level(userlevelname) VALUES (?)");
  $stmt->bind_param("s", $levelName);

  if ($stmt->execute()) {
    //sweet alert for successful submission with script
    // Using JavaScript to show a success message
    // This will be executed after the form is submitted successfully
   echo "<script>
    Swal.fire({
        title: 'Success!',
        text: 'New user level created successfully',
        icon: 'success',
        confirmButtonText: 'OK'
    }).then(() => {
        document.getElementById('userLevelForm').reset();
    });
</script>";
  } else {
    echo "Error: " . $stmt->error;
  }

  $stmt->close();
}

?>
<!DOCTYPE html> 
<html>
<?php include 'head.php'; ?>
<body>
  <div class="form-container">
    <h1 class="form-title">User Levels Form</h1>

    <form id="userLevelForm" onsubmit="return submitLevelForm()" method="post">
      <div class="form-group">
        <label for="levelName">Level Name</label>
        <input type="text" id="levelName" name="levelName" class="form-control" required>
      </div>

      <button type="submit" class="btn btn-primary">Save Level</button>
      <div class="success mt-3" id="successMsg"></div>
    </form>
  </div>
</body>

</html>
