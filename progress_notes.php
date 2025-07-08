<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//include database connection
include 'dbconnect.php';

//handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_date = $_POST['input_date'];
    $history = $_POST['history'];
    $WT = $_POST['WT'];
    $HT = $_POST['HT'];
    $HC = $_POST['HC'];
    $Temp = $_POST['Temp'];
    $diagnosis = $_POST['diagnosis'];
    $plan = $_POST['plan'];

    $stmt = $conn->prepare("INSERT INTO progress_notes 
    (input_date, history, WT, HT, HC, Temp, diagnosis, plan)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt) {
        // If your DB columns for WT, HT, HC, Temp are DECIMAL/FLOAT
        $stmt->bind_param("ssddddss", $input_date, $history, $WT, $HT, $HC, $Temp, $diagnosis, $plan);
        if ($stmt->execute()) {
            echo "<p style='color:green;'>✅ Saved successfully</p>";
        } else {
            echo "Error executing: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Prepare failed: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Child Admission Form</title>
    
</head>
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
        input[type="text"], input[type="date"], input[type="number"], textarea, select {
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
        input[type="text"] {
            height: 40px;
            font-size: 18px;
        }
        #deceasedFields {
            grid-column: 1 / -1;
        }
        @media (max-width: 700px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }

    </style>
<body>
    <form method="POST" action="">
        <section>
            <h1 class="login-title">Progress Notes</h1>

            <div class="form-grid">
                <div>
                    <label for="input_date">Input Date:</label>
                    <input type="date" id="input_date" name="input_date" required>
                </div>
                <div>
                    <label for="history">History:</label>
                    <textarea id="history" name="history" rows="6" placeholder="Enter history" required></textarea>
                </div>
                <div>
                    <label for="WT">WT (kg):</label>
                    <input type="number" step="0.01" id="WT" name="WT" placeholder="Enter weight" required>
                </div>
                <div>
                    <label for="HT">HT (cm):</label>
                    <input type="number" step="0.01" id="HT" name="HT" placeholder="Enter height" required>
                </div>
                <div>
                    <label for="HC">HC (cm):</label>
                    <input type="number" step="0.01" id="HC" name="HC" placeholder="Enter head circumference" required>
                </div>
                <div>
                    <label for="Temp">Temp (°C):</label>
                    <input type="number" step="0.01" id="Temp" name="Temp" placeholder="Enter temperature" required>
                </div>
                <div>
                    <label for="diagnosis">Diagnosis:</label>
                    <textarea id="diagnosis" name="diagnosis" rows="4" placeholder="Enter diagnosis" required></textarea>
                </div>
                <div>
                    <label for="plan">Plan:</label>
                    <textarea id="plan" name="plan" rows="6" placeholder="Enter plan" required></textarea>
                </div>
                <button type="submit">Submit</button>
            </div>
        </section>
    </form>
</body>
</html>
