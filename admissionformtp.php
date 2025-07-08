<?php
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
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            title: "Admission Examination",
            text: "Please fill out the form carefully.",
            icon: "info",
            confirmButtonText: "Got it!",
            customClass: {
                popup: "swal-popup",
                title: "swal-title",
                content: "swal-content",
                confirmButton: "swal-confirm-button"
            }
        });
    });
    </script>';


?>

<!DOCTYPE html>
<html>
<head>
    <title>ADMISSION FORM</title>

    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: #eafcff;
        }
        form {
            width: 90vw;
            max-width: 1000px;
            min-width: 320px;
        }
        section {
            background-color: #fff;
            padding: 32px;
            border-radius: 16px;
            margin-bottom: 24px;
            box-shadow: 0 0 16px rgba(1, 247, 255, 0.5);
        }
        .form-grid {
            display: flex;
            flex-direction: column;
            gap: 0;
        }
        .form-grid > div {
            display: flex;
            flex-direction: column;
        }
        h1.login-title {
            color: #fff;
            text-shadow: 0 0 10px #00fff7, 0 0 20px #00fff7, 0 0 40px #00fff7;
            background: #00bcd4;
            text-align: center;
            border-radius: 8px;
            padding: 8px 0;
            margin-bottom: 16px;
            grid-column: 1 / -1;
        }
        label, input, textarea, button, select {
            font-size: 1.1em;
            font-family: Arial, sans-serif;
        }
        label {
            margin-bottom: 4px;
            color: #015e6b;
        }
        input[type="text"], input[type="date"], input[type="number"], input[type="tel"], textarea, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #b2ebf2;
            border-radius: 6px;
            box-sizing: border-box;
            background: #f7feff;
        }
        input[type="radio"], input[type="checkbox"] {
            width: auto;
            margin-right: 8px;
        }
        .radio-group, .radio-inline {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }
        button {
            background-color: aqua;
            color: #fff;
            text-shadow: 0 0 10px #00fff7, 0 0 20px #00fff7, 0 0 40px #00fff7;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            cursor: pointer;
            display: block;
            margin: 24px auto 0 auto;
        }
        /* Increase the size of the textbox and its text */
        input[type="text"] {
            width: 100%;
            height: 40px;
            font-size: 18px;
            padding: 8px;
        }
        /* Make deceased section full width */
        #deceasedFields {
            grid-column: 1 / -1;
        }
        @media (max-width: 700px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

    <body>
        <form action="admissionformtp.php" method="post">
        <section>
                <h1 class="login-title">Admission form</h1>
        
                <label for="family_name">Family Name:</label>
                <input type="text" id="family_name" name="family_name" placeholder="Enter family name" required>

                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" placeholder="Enter first name" required>

                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" placeholder="Enter last name" required>

                <label for="sex">Sex:</label>
                <input type="radio" id="sex_male" name="sex" value="male" required>
                <label for="sex_male">Male</label>
                <input type="radio" id="sex_female" name="sex" value="female" required>
                <label for="sex_female">Female</label><br><br>

               <!-- Remove the duplicate -->
                <label for="dob">Date of Birth (yyyy-mm-dd):</label>
                <input type="date" id="dob" name="dob" required>

                <label for="birth_weight">Birth Weight (kg):</label>
                <input type="number" id="birth_weight" name="birth_weight" step="0.01" placeholder="Enter birth weight" required>

                <label for="breastfed">Breastfed:</label>
                <input type="radio" id="breastfed_yes" name="breastfed" value="yes" required>
                <label for="breastfed_yes">Yes</label>
                <input type="radio" id="breastfed_no" name="breastfed" value="no" required>
                <label for="breastfed_no">No</label><br><br>

                <label for="date_of_admission">Date of Admission:</label>
                <input type="date" id="date_of_admission" name="date_of_admission" required>

                <label for="age_of_admission">Age at Admission (years):</label>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <input type="number" id="age_of_admission" name="age_of_admission" min="0" placeholder="Age at admission" required style="flex:1;">
                    <button type="button" onclick="calculateAgeAtAdmission()" style="background-color: rgb(1, 183, 255); color: rgb(5, 5, 5); border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; margin-left: 10px;">Calculate Age</button>
                </div>
                
                <div id="age_approx_info" style="color: #015e6b; margin-bottom: 16px; font-size: 0.95em;"></div>
                    
                    <label for="weight_on_admission">Weight on Admission (kg):</label>
                    <input type="number" id="weight_on_admission" name="weight_on_admission" step="0.01" placeholder="Enter weight on admission" required>

                    <label for="referral_source">Referral Source:</label>
                    <input type="text" id="referral_source" name="referral_source" placeholder="Enter referral source" required>

                    <label for="mother_name">Name of the Mother:</label>
                    <input type="text" id="mother_name" name="mother_name" placeholder="Enter mother's name" required>

                    <label for="mother_life_status">Life Status of the Mother:</label>
                    <select id="mother_life_status" name="mother_life_status" required>
                        <option value="">Select</option>
                        <option value="alive">Alive</option>
                        <option value="deceased">Deceased</option>
                        <option value="unknown">Unknown</option>
                    </select>

                    <label for="mother_hiv_status">HIV Status of the Mother:</label>
                    <select id="mother_hiv_status" name="mother_hiv_status" required>
                        <option value="">Select</option>
                        <option value="positive">Positive</option>
                        <option value="negative">Negative</option>
                        <option value="unknown">Unknown</option>
                    </select>

                    <label for="father_name">Name of the Father:</label>
                    <input type="text" id="father_name" name="father_name" placeholder="Enter father's name" required>

                    <label for="father_life_status">Life Status of the Father:</label>
                    <select id="father_life_status" name="father_life_status" required>
                        <option value="">Select</option>
                        <option value="alive">Alive</option>
                        <option value="deceased">Deceased</option>
                        <option value="unknown">Unknown</option>
                    </select>

                    <label for="father_hiv_status">HIV Status of the Father:</label>
                    <select id="father_hiv_status" name="father_hiv_status" required>
                        <option value="">Select</option>
                        <option value="positive">Positive</option>
                        <option value="negative">Negative</option>
                        <option value="unknown">Unknown</option>
                    </select>

                    <label for="birth_order">Birth Order:</label>
                    <input type="number" id="birth_order" name="birth_order" min="1" placeholder="Enter birth order" required>

                    <label for="no_of_siblings">Number of Siblings:</label>
                    <input type="number" id="no_of_siblings" name="no_of_siblings" min="0" placeholder="Enter number of siblings" required>

                    <label for="no_of_hiv_positive">Number of HIV Positive Siblings:</label>
                    <input type="number" id="no_of_hiv_positive" name="no_of_hiv_positive" min="0" placeholder="Enter number" required>

                    <label for="no_of_hiv_negative">Number of HIV Negative Siblings:</label>
                    <input type="number" id="no_of_hiv_negative" name="no_of_hiv_negative" min="0" placeholder="Enter number" required>

                    <label for="child_life_status">Child Life Status:</label>
                    <select id="child_life_status" name="child_life_status" required onchange="toggleDeceasedFields()">
                        <option value="">Select</option>
                        <option value="alive">Alive</option>
                        <option value="deceased">Deceased</option>
                    </select>

                    <label for="present_caretaker">Present Care Taker:</label>
                    <input type="text" id="present_caretaker" name="present_caretaker" placeholder="Enter present care taker" required>
                    
        
                <section id="deceasedFields" style="display:none;">
                    <h1 class="login-title">If Child is Deceased</h1>
                    <label for="age_of_death">Age of Death (years):</label>
                    <input type="number" id="age_of_death" name="age_of_death" min="0" placeholder="Enter age at death">

                    <label for="cause_of_death">Cause of Death:</label>
                    <input type="text" id="cause_of_death" name="cause_of_death" placeholder="Enter cause of death">

                    <label for="date_of_death">Date of Death:</label>
                    <input type="date" id="date_of_death" name="date_of_death">

                    <label for="child_left">Child Left:</label>
                    <input type="radio" id="child_left_yes" name="child_left" value="yes">
                    <label for="child_left_yes">Yes</label>
                    <input type="radio" id="child_left_no" name="child_left" value="no">
                    <label for="child_left_no">No</label>
                </section>

                            
                        <button type="submit" style="background-color: rgb(1, 183, 255); color: rgb(5, 5, 5);">Submit</button>
            </section>
                        </form>
                
                        <script>
                        function calculateAgeAtAdmission() {
                            var dob = document.getElementById('dob').value;
                            var doa = document.getElementById('date_of_admission').value;
                            var infoDiv = document.getElementById('age_approx_info');
                            if (!dob || !doa) {
                                alert('Please enter both Date of Birth and Date of Admission');
                                return;
                            }
                            var dobDate = new Date(dob);
                            var doaDate = new Date(doa);
                            if (doaDate < dobDate) {
                                alert('Admission date cannot be before date of birth');
                                return;
                            }
                            var years = doaDate.getFullYear() - dobDate.getFullYear();
                            var months = doaDate.getMonth() - dobDate.getMonth();
                            var days = doaDate.getDate() - dobDate.getDate();
                            if (days < 0) {
                                months--;
                                days += new Date(doaDate.getFullYear(), doaDate.getMonth(), 0).getDate();
                            }
                            if (months < 0) {
                                years--;
                                months += 12;
                            }
                            document.getElementById('age_of_admission').value = years;
                            infoDiv.textContent = "Approximate age at admission: " + years + " years, " + months + " months, " + days + " days.";
                        }
                
                        function toggleDeceasedFields() {
                            var status = document.getElementById('child_life_status').value;
                            var deceasedFields = document.getElementById('deceasedFields');
                            deceasedFields.style.display = (status === 'deceased') ? 'block' : 'none';
                        }
                        </script>
                    </body>
                </html>
                