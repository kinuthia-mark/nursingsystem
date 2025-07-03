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
<head>
    <title>Discharge Form</title>
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
            max-width: 900px;
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
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px 32px;
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
    <form action="discharge_abstract.php" method="POST">
        <section>
            <h1 class="login-title">Discharge Abstract</h1>

            <label for="discharge_date">Discharge Date:</label>
            <input type="date" id="discharge_date" name="discharge_date" required>

            <label for="discharge_weight">Discharge Weight (Kg):</label>
            <input type="number" id="discharge_weight" name="discharge_weight" step="0.1" required>

            <label for="discharge_height">Discharge Height (cm):</label>
            <input type="number" id="discharge_height" name="discharge_height" step="0.1" required>

            <label for="adherence">Adherence:</label>
            <input type="text" id="adherence" name="adherence" required>

            <label for="ccc_name">Name of CCC:</label>
            <input type="text" id="ccc_name" name="ccc_name" required>

            <label for="discharge_doctor">Discharge Doctor:</label>
            <input type="text" id="discharge_doctor" name="discharge_doctor" required>

            <label for="admission">Admission:</label>
            <textarea id="admission" name="admission" rows="4" required></textarea>

            <label for="clinical_progress">Clinical Progress:</label>
            <textarea id="clinical_progress" name="clinical_progress" rows="4" required></textarea>

            <label for="condition_at_discharge">Condition at Discharge:</label>
            <textarea id="condition_at_discharge" name="condition_at_discharge" rows="4" required></textarea>

            <button type="submit">Submit</button>
        </section>
    </form>
</body>
</html>
