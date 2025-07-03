<?php
//include database connection
include 'dbconnect.php';


//error reporting
error_reporting(E_ALL);
ini_set('display_errors', 0);// Set to 1 to display errors, 0 to hide them

//handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $fullname = htmlspecialchars(trim($_POST['fullname']));
    $dob = htmlspecialchars(trim($_POST['dob']));
    $gender = htmlspecialchars(trim($_POST['gender']));
    $admissiondate = htmlspecialchars(trim($_POST['admissiondate']));
    $guardianname = htmlspecialchars(trim($_POST['guardianname']));
    $relationship = htmlspecialchars(trim($_POST['relationship']));
    $guardianphone = htmlspecialchars(trim($_POST['guardianphone']));
    $emergencycontactperson = htmlspecialchars(trim($_POST['emergencycontactperson']));
    $emergencycontactphone = htmlspecialchars(trim($_POST['emergencycontactphone']));
    $medicalhistory = htmlspecialchars(trim($_POST['medicalhistory']));
    $allergies = htmlspecialchars(trim($_POST['allergies']));
    $currentmedications = htmlspecialchars(trim($_POST['currentmedications']));
    $vaccinationstatus = htmlspecialchars(trim($_POST['vaccinationstatus']));
    $specialneeds = htmlspecialchars(trim($_POST['specialneeds']));
    $additionalinfo = htmlspecialchars(trim($_POST['additionalinfo']));
    $immunization = isset($_POST['immunization']) ? implode(", ", $_POST['immunization']) : '';
    $bcg_date = htmlspecialchars(trim($_POST['bcg_date']));
    $polio_date = htmlspecialchars(trim($_POST['polio_date']));
    $dpt_date = htmlspecialchars(trim($_POST['dpt_date']));
    $hepatitisb_date = htmlspecialchars(trim($_POST['hepatitisb_date']));
    $measles_date = htmlspecialchars(trim($_POST['measles_date']));
    $others_specify = htmlspecialchars(trim($_POST['others_specify']));
    $others_date = htmlspecialchars(trim($_POST['others_date']));
    $weight = htmlspecialchars(trim($_POST['weight']));
    $height = htmlspecialchars(trim($_POST['height']));
    $bloodpressure = htmlspecialchars(trim($_POST['bloodpressure']));
    $temperature = htmlspecialchars(trim($_POST['temperature']));
    $observations = htmlspecialchars(trim($_POST['observations']));
    $nurse_name = htmlspecialchars(trim($_POST['nurse_name']));
    $nurse_signature = htmlspecialchars(trim($_POST['nurse_signature']));
    $date = htmlspecialchars(trim($_POST['date']));   
 
    // Prepare SQL statement
    $sql = "INSERT INTO medical_forms (
        fullname, dob, gender, admissiondate, guardianname, relationship, guardianphone,
        emergencycontactperson, emergencycontactphone, medicalhistory, allergies, currentmedications,
        vaccinationstatus, specialneeds, additionalinfo, immunization, bcg_date, polio_date, dpt_date,
        hepatitisb_date, measles_date, others_specify, others_date, weight, height, bloodpressure,
        temperature, observations, nurse_name, nurse_signature, date
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if (!$conn) {
        echo "<script>alert('Database connection failed.');</script>";
        exit;
    }

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "<script>alert('Statement preparation failed: " . $conn->error . "');</script>";
        exit;
    }

    $stmt->bind_param(
        "sssssssssssssssssssssssssssssss",
        $fullname, $dob, $gender, $admissiondate, $guardianname, $relationship, $guardianphone,
        $emergencycontactperson, $emergencycontactphone, $medicalhistory, $allergies, $currentmedications,
        $vaccinationstatus, $specialneeds, $additionalinfo, $immunization, $bcg_date, $polio_date, $dpt_date,
        $hepatitisb_date, $measles_date, $others_specify, $others_date, $weight, $height, $bloodpressure,
        $temperature, $observations, $nurse_name, $nurse_signature, $date
    );

    if ($stmt->execute()) {
        echo "<script>alert('Form submitted successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>MEDICAL FORM</title>
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
            width: 100vw;
            max-width: 100vw;
            min-width: 100vw;
        }
        section {
            background-color: #fff;
            padding: 32px;
            border-radius: 16px;
            margin-bottom: 24px;
            box-shadow: 0 0 16px rgba(1, 247, 255, 0.5);
        }
        h1.login-title {
            color: #fff;
            text-shadow: 0 0 10px #00fff7, 0 0 20px #00fff7, 0 0 40px #00fff7;
            background: #00bcd4;
            border-radius: 8px;
            padding: 8px 0;
            margin-bottom: 16px;
        }
        label, input, textarea, button {
            font-size: 1.1em;
            font-family: Arial, sans-serif;
        }
        label {
            display: block;
            margin-bottom: 4px;
            color: #015e6b;
        }
    input[type="text"], input[type="date"], input[type="number"], input[type="tel"], textarea {
        width: 100%;
        padding: 8px;
        margin-bottom: 16px;
        border: 1px solid #b2ebf2;
        border-radius: 6px;
        box-sizing: border-box;
        background: #f7feff;
    }
</style>

<form method="POST" action="medical_form.php">
        <section>
            <h1 class="login-title">Child Basic Information</h1>
            <p>Please fill out the form below with your medical information.</p>
            <p>Ensure all fields are completed accurately.</p>
            <p>Once completed, click the submit button to save your information.</p>
            <label for="fullname">Full Name</label>
            <input type="text" id="fullname" name="fullname" required><br><br>
            <label for="dob">Date Of Birth</label>
            <input type="date" id="dob" name="dob" required><br><br>
            <label for="gender">Gender</label>
            <input type="radio" id="male" name="gender" value="male" required>
            <label for="male">Male</label>
            <input type="radio" id="female" name="gender" value="female" required>
            <label for="female">Female</label><br><br>
            <label for="admissiondate">Admission Date</label>
            <input type="date" id="admissiondate" name="admissiondate" required><br><br>
        </section>
        <section>
            <h1 class="login-title">GUARDIAN INFORMATION</h1>
            <p>Please fill out the form below with your guardian's information.</p>
            <p>Ensure all fields are completed accurately.</p>
            <label for="guardianname">Guardian Name</label>
            <input type="text" id="guardianname" name="guardianname" required><br><br>
            <label for="relationship">Relationship</label>
            <input type="text" id="relationship" name="relationship" required><br><br>
            <label for="guardianphone">Guardian Phone</label>
            <input type="tel" id="guardianphone" name="guardianphone" required><br><br>
            <label for="emergencycontactperson">Emergency Contact Person</label>
            <input type="text" id="emergencycontactperson" name="emergencycontactperson" required><br><br>
            <label for="emergencycontactphone">Emergency Contact Phone</label>
            <input type="tel" id="emergencycontactphone" name="emergencycontactphone" required><br><br>
        </section>
        <section>
            <h1 class="login-title">Medical Background</h1>
            <p>Please fill out the form below with your medical background.</p>
            <p>Ensure all fields are completed accurately.</p>
            <label for="medicalhistory">Known Medical History</label>
            <textarea id="medicalhistory" name="medicalhistory" rows="4" cols="50" required></textarea><br><br>
            <label for="allergies">Allergies</label>
            <textarea id="allergies" name="allergies" rows="4" cols="50"></textarea><br><br>
            <label for="currentmedications">Current Medications</label>
            <textarea id="currentmedications" name="currentmedications" rows="4" cols="50"></textarea><br><br>
            <label for="vaccinationstatus">Vaccination Status</label>
            <input type="text" id="vaccinationstatus" name="vaccinationstatus"><br><br>
            <label for="specialneeds">Disabilities/Special Needs</label>
            <textarea id="specialneeds" name="specialneeds" rows="4" cols="50"></textarea><br><br>
            <label for="additionalinfo">Additional Information</label>
            <textarea id="additionalinfo" name="additionalinfo" rows="4" cols="50"></textarea><br><br>
        </section>
        <section>
            <h1 class="login-title">Immunization</h1>
            <p>please tick all that apply and the date of last applied</p>
            <p>Ensure all fields are completed accurately.</p>
            <div>
                <input type="checkbox" id="bcg" name="immunization[]" value="BCG">
                <label for="bcg">BCG</label>
                <label for="bcg_date">Date of Last Immunized:</label>
                <input type="date" id="bcg_date" name="bcg_date"><br><br>

                <input type="checkbox" id="polio" name="immunization[]" value="POLIO">
                <label for="polio">POLIO</label>
                <label for="polio_date">Date of Last Immunized:</label>
                <input type="date" id="polio_date" name="polio_date"><br><br>

                <input type="checkbox" id="dpt" name="immunization[]" value="DPT">
                <label for="dpt">DPT</label>
                <label for="dpt_date">Date of Last Immunized:</label>
                <input type="date" id="dpt_date" name="dpt_date"><br><br>

                <input type="checkbox" id="hepatitisb" name="immunization[]" value="HEPATITIS B">
                <label for="hepatitisb">HEPATITIS B</label>
                <label for="hepatitisb_date">Date of Last Immunized:</label>
                <input type="date" id="hepatitisb_date" name="hepatitisb_date"><br><br>

            </div>
        </section>
        <section>
            <h1 class="login-title">Current Status</h1>
            <p>Please fill out the form below with your current status.</p>
            <p>Ensure all fields are completed accurately.</p>
            <label for="weight">weight</label>
            <input type="number" id="weight" name="weight" required><br><br>
            <label for="height">height</label>
            <input type="number" id="height" name="height" required><br><br>
            <label for="bloodpressure">Blood Pressure</label>
            <input type="text" id="bloodpressure" name="bloodpressure" required><br><br>
            <label for="temperature">Temperature</label>
            <input type="number" id="temperature" name="temperature" required><br><br>
            <label for="observations">Observations</label>
            <textarea id="observations" name="observations" rows="4" cols="50" required placeholder="Describe skin condition, appetite, sleep habits, etc."></textarea><br><br>

        </section>  
            <label for="height">height</label>
            <input type="number" id="height" name="height" required><br><br>
            <label for="bloodpressure">Blood Pressure</label>
            <input type="text" id="bloodpressure" name="bloodpressure" required><br><br>
            <label for="temperature">Temperature</label>
            <input type="number" id="temperature" name="temperature" required><br><br>
            <label for="observations">Observations</label>
            <textarea id="observations" name="observations" rows="4" cols="50" required placeholder="Describe skin condition, appetite, sleep habits, etc."></textarea><br><br>

        </section>  
        <section>
            <h1 class="login-title">Final officials information</h1>
            <label for="nurse name">Nurse Name</label>
            <input type="text" id="nurse_name" name="nurse_name" required><br><br>
            <label for="nurse signature">Nurse Signature</label>
            <input type="text" id="nurse_signature" name="nurse_signature" required><br><br>
            <label for="date">Date</label>
            <input type="date" id="date" name="date" required><br><br>
        <button type="submit" style="background-color: rgb(1, 183, 255); color: rgb(5, 5, 5);">submit</button>
        </section>  
    </form>
</body>
</html>