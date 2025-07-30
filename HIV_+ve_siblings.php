<?php
//include 'db_connection.php'; // Include your database connection file
include 'dbconnect.php'; 

//error reporting settings
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check database connection
if (!isset($conn) || $conn->connect_error) {
    die("<div style='color: red; text-align: center;'>Database connection failed: " . htmlspecialchars($conn->connect_error) . "</div>");
}
/*
 * The Siblings No input and handling have been removed.
 * The database table 'hiv_positive_siblings' should have 'siblings_no' as AUTO_INCREMENT PRIMARY KEY.
 * When inserting, do not include 'siblings_no' in the INSERT statement.
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form values and sanitize
    $siblings_no = isset($_POST['siblings_no']) ? intval($_POST['siblings_no']) : null;
    $first_name = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
    $last_name = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
    $age = isset($_POST['age']) ? intval($_POST['age']) : null;
    $sibling_sex = isset($_POST['sibling_sex']) ? trim($_POST['sibling_sex']) : '';

    // Simple validation (add more as needed)
    if ($siblings_no !== null && $first_name && $last_name && $age !== null && $sibling_sex) {
        // Prepare and execute insert query
        $stmt = $conn->prepare("INSERT INTO hiv_positive_siblings (siblings_no, first_name, last_name, age, sex) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issis", $siblings_no, $first_name, $last_name, $age, $sibling_sex);

        if ($stmt->execute()) {
            echo "<div style='color: green; text-align: center;'>Sibling information saved successfully.</div>";
        } else {
            echo "<div style='color: red; text-align: center;'>Error saving sibling information.</div>";
        }
        $stmt->close();
    } else {
        echo "<div style='color: red; text-align: center;'>Please fill in all fields.</div>";
    }
}

//include sweet alert library
 //   echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
   // echo '<script>
    //document.addEventListener("DOMContentLoaded", function() {
     //   Swal.fire({
      //      title: "Admission Examination",
      //      text: "Please fill out the form carefully.",
      //      icon: "info",
      //      confirmButtonText: "Got it!",
       //    customClass: {
        //        popup: "swal-popup",
       //         title: "swal-title",
       //         content: "swal-content",
       //         confirmButton: "swal-confirm-button"
       //     }
      //  });
  //  });
 //   </script>';
// Close the database connection

?>
<!DOCTYPE html>
<?php include 'head.php'; ?>
<body>
    
<form action="HIV_+ve_siblings.php" method="post">
  <section class="form-container">
    <h1 class="form-title">Siblings Information</h1>

    <div class="form-grid">
      <div>
        <label for="siblings_no">Siblings No:</label>
        <input type="number" id="siblings_no" name="siblings_no" min="0" required>
      </div>

      <div>
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required>
      </div>

      <div>
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required>
      </div>

      <div>
        <label for="age">Age:</label>
        <input type="number" id="age" name="age" min="0" required>
      </div>

      <div>
        <label for="sibling_sex">Sex:</label>
        <select id="sibling_sex" name="sibling_sex" required>
          <option value="">Select</option>
          <option value="male">Male</option>
          <option value="female">Female</option>
        </select>
      </div>
    </div>

    <button type="submit">Submit</button>
  </section>
</form>

</body>
