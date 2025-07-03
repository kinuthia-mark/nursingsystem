
<!DOCTYPE html> 
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Levels Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #eef1f5;
      padding: 20px;
    }

    .form-container {
      max-width: 500px;
      background: #fff;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      margin: auto;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-top: 10px;
      font-weight: bold;
    }

    input[type="text"] {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .btn {
      background: #007bff;
      color: #fff;
      padding: 10px;
      margin-top: 15px;
      border: none;
      cursor: pointer;
      width: 100%;
      border-radius: 5px;
      font-size: 16px;
    }

    .btn:hover {
      background: #0056b3;
    }

    .success {
      text-align: center;
      color: green;
      margin-top: 10px;
    }
  </style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    
</head>
<body>

<?php 
//ERROR REPORTING
error_reporting(E_ALL);
ini_set('display_errors', 1);

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


<div class="form-container">
  <h2>User Levels Form</h2>
  <form id="userLevelForm" onsubmit="return submitLevelForm()" method="post">
    <label for="levelName">Level Name</label>
    <input type="text" id="levelName" name="levelName" required>

    <button type="submit" class="btn">Save Level</button>
    <div class="success" id="successMsg"></div>
  </form>
</div>

<!-- <script>
  function submitLevelForm() {
    const level = document.getElementById("levelName").value;
    document.getElementById("successMsg").textContent = `"${level}" level saved successfully!`;
    return false; // prevent actual submission (for demo only)
  }
</script> -->

</body>
</html>
