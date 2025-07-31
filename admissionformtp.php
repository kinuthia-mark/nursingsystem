<?php
//session.php
include 'session.php';
//include database connection
include 'dbconnect.php';

//error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

//handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // your POST logic
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dob)) {
        die('Invalid date of birth format.');
    }
    // Usual required stuff
    $family_name = mysqli_real_escape_string($conn, $_POST['family_name']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $sex = mysqli_real_escape_string($conn, $_POST['sex']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $birth_weight = floatval($_POST['birth_weight']);
    $breastfed = mysqli_real_escape_string($conn, $_POST['breastfed']);
    $date_of_admission = mysqli_real_escape_string($conn, $_POST['date_of_admission']);
    $age_of_admission = mysqli_real_escape_string($conn, $_POST['age_of_admission']);
    $weight_on_admission = floatval($_POST['weight_on_admission']);
    $referral_source = mysqli_real_escape_string($conn, $_POST['referral_source']);
    $mother_name = mysqli_real_escape_string($conn, $_POST['mother_name']);
    $mother_life_status = mysqli_real_escape_string($conn, $_POST['mother_life_status']);
    $mother_hiv_status = mysqli_real_escape_string($conn, $_POST['mother_hiv_status']);
    $father_name = mysqli_real_escape_string($conn, $_POST['father_name']);
    $father_life_status = mysqli_real_escape_string($conn, $_POST['father_life_status']);
    $father_hiv_status = mysqli_real_escape_string($conn, $_POST['father_hiv_status']);
    $birth_order = intval($_POST['birth_order']);
    $no_of_siblings = intval($_POST['no_of_siblings']);
    $no_of_hiv_positive = intval($_POST['no_of_hiv_positive']);
    $no_of_hiv_negative = intval($_POST['no_of_hiv_negative']);
    $child_life_status = mysqli_real_escape_string($conn, $_POST['child_life_status']);
    $present_caretaker = mysqli_real_escape_string($conn, $_POST['present_caretaker']);

    // Deceased fields - safe NULL handling
    $age_of_death = isset($_POST['age_of_death']) && trim($_POST['age_of_death']) !== '' ? intval($_POST['age_of_death']) : null;
    $cause_of_death = isset($_POST['cause_of_death']) && trim($_POST['cause_of_death']) !== '' ? trim($_POST['cause_of_death']) : null;
    $date_of_death = isset($_POST['date_of_death']) && trim($_POST['date_of_death']) !== '' ? trim($_POST['date_of_death']) : null;
    $child_left = isset($_POST['child_left']) && trim($_POST['child_left']) !== '' ? trim($_POST['child_left']) : null;

    // Prepare SQL with NULLIF for date_of_death
    $sql = "INSERT INTO admissionformtp (
    family_name, first_name, last_name, sex, dob, birth_weight, breastfed, date_of_admission, age_of_admission,
    weight_on_admission, referral_source, mother_name, mother_life_status, mother_hiv_status, father_name,
    father_life_status, father_hiv_status, birth_order, no_of_siblings, no_of_hiv_positive, no_of_hiv_negative,
    child_life_status, present_caretaker, age_of_death, cause_of_death, date_of_death, child_left
    ) VALUES (
    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )";

    $stmt = $conn->prepare($sql);

    // Corrected bind_param type string: 19 strings, 4 integers, 2 doubles, 2 nullable strings
    $stmt->bind_param(
        'sssssdsssssssssiissssssssss',
        $family_name, $first_name, $last_name, $sex, $dob, $birth_weight, $breastfed,
        $date_of_admission, $age_of_admission, $weight_on_admission, $referral_source, $mother_name,
        $mother_life_status, $mother_hiv_status, $father_name, $father_life_status, $father_hiv_status,
        $birth_order, $no_of_siblings, $no_of_hiv_positive, $no_of_hiv_negative, $child_life_status,
        $present_caretaker, $age_of_death, $cause_of_death, $date_of_death, $child_left
    );
    
    // Execute the prepared statement

    if ($stmt->execute()) {
        echo "<script>alert('Admission form submitted successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
    $conn->close();
}
// End of form submission handling

//include sweet alert library
    //echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    //echo '<script>
    //document.addEventListener("DOMContentLoaded", function() {
     //   Swal.fire({
      //      title: "Admission Examination",
        //    text: "Please fill out the form carefully.",
          //  icon: "info",
            //confirmButtonText: "Got it!",
            //customClass: {
              //  popup: "swal-popup",
               // title: "swal-title",
                //content: "swal-content",
                //confirmButton: "swal-confirm-button"
           // }
        //});
   // });
    //</script>';


?>

<!DOCTYPE html>
<html>
<head>
    <title>ADMISSION FORM</title>

<?php include 'head.php'; ?>

    <body>

    <?php include 'sidenav.php'; ?>

        <form action="admissionformtp.php" method="post" class="form-container">
  <h1 class="form-title">Admission Form</h1>

  <div class="form-grid">

    <div class="form-group">
      <label for="family_name">Family Name:</label>
      <input type="text" id="family_name" name="family_name" placeholder="Enter family name" required>
    </div>

    <div class="form-group">
      <label for="first_name">First Name:</label>
      <input type="text" id="first_name" name="first_name" placeholder="Enter first name" required>
    </div>

    <div class="form-group">
      <label for="last_name">Last Name:</label>
      <input type="text" id="last_name" name="last_name" placeholder="Enter last name" required>
    </div>

    <div class="form-group">
      <label>Sex:</label>
      <label><input type="radio" name="sex" value="male" required> Male</label>
      <label><input type="radio" name="sex" value="female" required> Female</label>
    </div>

    <div class="form-group">
      <label for="dob">Date of Birth:</label>
      <input type="date" id="dob" name="dob" required>
    </div>

    <div class="form-group">
      <label for="birth_weight">Birth Weight (kg):</label>
      <input type="number" id="birth_weight" name="birth_weight" step="0.01" placeholder="Enter birth weight" required>
    </div>

    <div class="form-group">
      <label>Breastfed:</label>
      <label><input type="radio" name="breastfed" value="yes" required> Yes</label>
      <label><input type="radio" name="breastfed" value="no" required> No</label>
    </div>

    <div class="form-group">
      <label for="date_of_admission">Date of Admission:</label>
      <input type="date" id="date_of_admission" name="date_of_admission" required>
    </div>

    <div class="form-group">
      <label for="age_of_admission">Age at Admission (years):</label>
      <input type="number" id="age_of_admission" name="age_of_admission" min="0" placeholder="Age at admission" required>
      <button type="button" onclick="calculateAgeAtAdmission()">Calculate Age</button>
      <div id="age_approx_info" style="font-size: 0.9em; color: #015e6b;"></div>
    </div>

    <div class="form-group">
      <label for="weight_on_admission">Weight on Admission (kg):</label>
      <input type="number" id="weight_on_admission" name="weight_on_admission" step="0.01" placeholder="Enter weight on admission" required>
    </div>

    <div class="form-group">
      <label for="referral_source">Referral Source:</label>
      <input type="text" id="referral_source" name="referral_source" placeholder="Enter referral source" required>
    </div>

    <div class="form-group">
      <label for="mother_name">Mother’s Name:</label>
      <input type="text" id="mother_name" name="mother_name" placeholder="Enter mother's name" required>
    </div>

    <div class="form-group">
      <label for="mother_life_status">Mother’s Life Status:</label>
      <select id="mother_life_status" name="mother_life_status" required>
        <option value="">Select</option>
        <option value="alive">Alive</option>
        <option value="deceased">Deceased</option>
        <option value="unknown">Unknown</option>
      </select>
    </div>

    <div class="form-group">
      <label for="mother_hiv_status">Mother’s HIV Status:</label>
      <select id="mother_hiv_status" name="mother_hiv_status" required>
        <option value="">Select</option>
        <option value="positive">Positive</option>
        <option value="negative">Negative</option>
        <option value="unknown">Unknown</option>
      </select>
    </div>

    <div class="form-group">
      <label for="father_name">Father’s Name:</label>
      <input type="text" id="father_name" name="father_name" placeholder="Enter father's name" required>
    </div>

    <div class="form-group">
      <label for="father_life_status">Father’s Life Status:</label>
      <select id="father_life_status" name="father_life_status" required>
        <option value="">Select</option>
        <option value="alive">Alive</option>
        <option value="deceased">Deceased</option>
        <option value="unknown">Unknown</option>
      </select>
    </div>

    <div class="form-group">
      <label for="father_hiv_status">Father’s HIV Status:</label>
      <select id="father_hiv_status" name="father_hiv_status" required>
        <option value="">Select</option>
        <option value="positive">Positive</option>
        <option value="negative">Negative</option>
        <option value="unknown">Unknown</option>
      </select>
    </div>

    <div class="form-group">
      <label for="birth_order">Birth Order:</label>
      <input type="number" id="birth_order" name="birth_order" min="1" placeholder="Enter birth order" required>
    </div>

    <div class="form-group">
      <label for="no_of_siblings">Number of Siblings:</label>
      <input type="number" id="no_of_siblings" name="no_of_siblings" min="0" placeholder="Enter number of siblings" required>
    </div>

    <div class="form-group">
      <label for="no_of_hiv_positive">Number of HIV Positive Siblings:</label>
      <input type="number" id="no_of_hiv_positive" name="no_of_hiv_positive" min="0" placeholder="Enter number" required>
    </div>

    <div class="form-group">
      <label for="no_of_hiv_negative">Number of HIV Negative Siblings:</label>
      <input type="number" id="no_of_hiv_negative" name="no_of_hiv_negative" min="0" placeholder="Enter number" required>
    </div>

    <div class="form-group">
      <label for="child_life_status">Child Life Status:</label>
      <select id="child_life_status" name="child_life_status" required onchange="toggleDeceasedFields()">
        <option value="">Select</option>
        <option value="alive">Alive</option>
        <option value="deceased">Deceased</option>
      </select>
    </div>

    <div class="form-group">
      <label for="present_caretaker">Present Caretaker:</label>
      <input type="text" id="present_caretaker" name="present_caretaker" placeholder="Enter present caretaker" required>
    </div>

    <!-- Deceased Fields -->
    <div class="form-group" id="deceasedFields" style="display:none;">
      <h3>If Child is Deceased</h3>
      <label for="age_of_death">Age of Death (years):</label>
      <input type="number" id="age_of_death" name="age_of_death" min="0" placeholder="Enter age at death">

      <label for="cause_of_death">Cause of Death:</label>
      <input type="text" id="cause_of_death" name="cause_of_death" placeholder="Enter cause of death">

      <label for="date_of_death">Date of Death:</label>
      <input type="date" id="date_of_death" name="date_of_death">

      <label>Child Left:</label>
      <label><input type="radio" name="child_left" value="yes"> Yes</label>
      <label><input type="radio" name="child_left" value="no"> No</label>
    </div>

  </div>

  <button type="submit">Submit</button>
</form>

    <script>
    function calculateAgeAtAdmission() {
        var dob = document.getElementById('dob').value;
        var doa = document.getElementById('date_of_admission').value;
        var infoDiv = document.getElementById('age_approx_info');
        if (!dob || !doa) {
        alert('Enter both DOB and Admission Date');
        return;
        }
        var dobDate = new Date(dob);
        var doaDate = new Date(doa);
        if (doaDate < dobDate) {
        alert('Admission can’t be before birth!');
        return;
        }
        var years = doaDate.getFullYear() - dobDate.getFullYear();
        var months = doaDate.getMonth() - dobDate.getMonth();
        var days = doaDate.getDate() - dobDate.getDate();
        if (days < 0) { months--; days += 30; }
        if (months < 0) { years--; months += 12; }
        document.getElementById('age_of_admission').value = years;
        infoDiv.textContent = "Approx age at admission: " + years + "y " + months + "m " + days + "d";
    }

    function toggleDeceasedFields() {
        var status = document.getElementById('child_life_status').value;
        var section = document.getElementById('deceasedFields');
        section.style.display = (status === 'deceased') ? 'block' : 'none';
    }
    </script>
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
    <script type="text/javascript" src="js/plugins/chart.js"></script>
    <script type="text/javascript"></script>

    </body>
</html>
                