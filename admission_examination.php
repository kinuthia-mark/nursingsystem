<?php 
// dbconnect.php
include 'dbconnect.php';
// error reporting settings
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Safely get POST values or set to empty string if not set
    $medical_history = $_POST['medical_history'] ?? '';
    $condition_field = $_POST['condition'] ?? '';
    $weight = $_POST['weight'] ?? '';
    $height = $_POST['height'] ?? '';
    $wasting = $_POST['wasting'] ?? '';
    $oedema = $_POST['oedema'] ?? '';
    $pallor = $_POST['pallor'] ?? '';
    $cyanosis = $_POST['cyanosis'] ?? '';
    $clubbing = $_POST['clubbing'] ?? '';
    $jaundice = $_POST['jaundice'] ?? '';
    $parotids = $_POST['parotids'] ?? '';
    $respiratory = $_POST['respiratory'] ?? '';
    $cvs = $_POST['cvs'] ?? '';
    $abdomen = $_POST['abdomen'] ?? '';
    $lymph_nodes = $_POST['lymph_nodes'] ?? '';
    $eyes = $_POST['eyes'] ?? '';
    $ent = $_POST['ent'] ?? '';
    $mouth = $_POST['mouth'] ?? '';
    $ulcers = $_POST['ulcers'] ?? '';
    $thrush = $_POST['thrush'] ?? '';
    $teeth = $_POST['teeth'] ?? '';
    $hair = $_POST['hair'] ?? '';
    $skin = $_POST['skin'] ?? '';
    $bcg_scar = $_POST['bcg_scar'] ?? '';
    $cns = $_POST['cns'] ?? '';
    $masculoskeletal = $_POST['masculoskeletal'] ?? '';
    $gross_motor = $_POST['gross_motor'] ?? '';
    $fine_motor = $_POST['fine_motor'] ?? '';
    $social = $_POST['social'] ?? '';
    $language = $_POST['language'] ?? '';
    $summary = $_POST['summary'] ?? '';
    $plan = $_POST['plan'] ?? '';

    // Use prepared statements to prevent SQL injection
    // Fix this line: use the SAME var name everywhere
    $stmt = $conn->prepare("
    INSERT INTO admission_examination 
    (
        medical_history, condition_field , weight, height, wasting, oedema, pallor, cyanosis, clubbing, jaundice, 
        parotids, respiratory, cvs, abdomen, lymph_nodes, eyes, ent, mouth, ulcers, thrush, 
        teeth, hair, skin, bcg_scar, cns, masculoskeletal, gross_motor, fine_motor, social, language, summary, plan
    ) 
    VALUES 
    (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )
    ");


    $stmt->bind_param(
        "ssssssssssssssssssssssssssssssss",
        $medical_history, $condition_field , $weight, $height, $wasting, $oedema, $pallor, $cyanosis, $clubbing, $jaundice,
        $parotids, $respiratory, $cvs, $abdomen, $lymph_nodes, $eyes, $ent, $mouth, $ulcers, $thrush,
        $teeth, $hair, $skin, $bcg_scar, $cns, $masculoskeletal, $gross_motor, $fine_motor, $social, $language, $summary, $plan
    );
        if ($stmt->execute()) {
            echo "<div style='color: green; text-align: center;'>Data saved successfully.</div>";
        } else {
            echo "<div style='color: red; text-align: center;'>Error saving data: " . $stmt->error . "</div>";
        }

        $stmt->close();
    }

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
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>admission_examination</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #eafcff;
        }
        h1.form-title {
            color: #fff;
            text-shadow: 0 0 10px #00fff7, 0 0 20px #00fff7, 0 0 40px #00fff7;
            background: #00bcd4;
            text-align: center;
            border-radius: 8px;
            padding: 8px 0;
            margin-bottom: 16px;
            grid-column: 1 / -1;
        }

        h2 {
            color: #015e6b;
            text-decoration: underline;
            text-align: left;
            margin-bottom: 24px;
        }
        form {
            background: linear-gradient(120deg, #eafcff 60%, #fff 100%);
            border-radius: 16px;
            box-shadow: 0 0 24px rgba(1, 247, 255, 0.18);
            padding: 40px;
            max-width: 900px;
            margin: 0 auto;
        }
        .form-container {
            display: flex;
            gap: 32px;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }
        .form-column {
            flex: 1;
            min-width: 280px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        label {
            font-weight: bold;
            color: #015e6b;
            margin-bottom: 4px;
        }
        input[name="weight"], input[name="height"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #b2ebf2;
            border-radius: 6px;
            background: #f7feff;
            font-size: 1em;
            margin-bottom: 10px;
            box-sizing: border-box;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        input[name="weight"]:focus, input[name="height"]:focus {
            border-color: #00bcd4;
            outline: none;
            box-shadow: 0 0 8px #00fff7;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #b2ebf2;
            border-radius: 6px;
            background: #f7feff;
            font-size: 1em;
            margin-bottom: 10px;
            box-sizing: border-box;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        input[type="text"]:focus, textarea:focus {
            border-color: #00bcd4;
            outline: none;
            box-shadow: 0 0 8px #00fff7;
        }
        textarea {
            min-height: 80px;
            resize: vertical;
        }
        button[type="submit"] {
            background-color: #00bcd4;
            color: #fff;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            padding: 12px 32px;
            font-size: 1.1em;
            cursor: pointer;
            margin-top: 16px;
            box-shadow: 0 2px 8px rgba(1, 247, 255, 0.10);
            transition: background 0.2s;
        }
        button[type="submit"]:hover {
            background: #0198a6;
        }

        h3 {
            color: #00bcd4;
            margin-top: 32px;
            margin-bottom: 12px;
        }
        @media (max-width: 800px) {
            .form-container {
                flex-direction: column;
                gap: 0;
            }
            form {
                padding: 16px;
            }
        }
    </style>
</head>
<body>
    

    <form method="POST" action="">
        <h1 class="form-title">Admission Examination</h1>
        <label for="medical_history">Medical History:</label>
        <textarea id="medical_history" name="medical_history" maxlength="255"></textarea>

        <h2>GENERAL EXAMINATION</h2>

        <div class="form-container">
            <div class="form-column">
                <label>Condition</label>
                <input type="text" name="condition" required />
                <label>Weight (kg)</label>
                <input type="number" name="weight" step="any" required />
                <label>Height (cm)</label>
                <input type="number" name="height" step="any" required />
                <label>Wasting</label>
                <input type="text" name="wasting" required />
                <label>Oedema</label>
                <input type="text" name="oedema" required />
                <label>Pallor</label>
                <input type="text" name="pallor" required />
                <label>Cyanosis</label>
                <input type="text" name="cyanosis" required />
                <label>Clubbing</label>
                <input type="text" name="clubbing" required />
                <label>Jaundice</label>
                <input type="text" name="jaundice" required />
                <label>Parotids</label>
                <input type="text" name="parotids" required />
                <label>Respiratory System</label>
                <input type="text" name="respiratory" required />
                <label>CVS</label>
                <input type="text" name="cvs" required />
                <label>Abdomen</label>
                <input type="text" name="abdomen" required />
            </div>

            <div class="form-column">
                <label>Lymph Nodes</label>
                <input type="text" name="lymph_nodes" />
                <label>Eyes</label>
                <input type="text" name="eyes" />
                <label>ENT</label>
                <input type="text" name="ent" />
                <label>Mouth</label>
                <input type="text" name="mouth" />
                <label>Ulcers</label>
                <input type="text" name="ulcers" />
                <label>Thrush</label>
                <input type="text" name="thrush" />
                <label>Teeth</label>
                <input type="text" name="teeth" />
                <label>Hair</label>
                <input type="text" name="hair" />
                <label>Skin</label>
                <input type="text" name="skin" />
                <label>BCG Scar</label>
                <input type="text" name="bcg_scar" />
                <label>CNS</label>
                <input type="text" name="cns" />
                <label>Masculoskeletal</label>
                <input type="text" name="masculoskeletal" />
            </div>
        </div>

        <h3 style="text-align: left;">Development</h3>
        <label>Gross Motor</label><input type="text" name="gross_motor" />
        <label>Fine Motor</label><input type="text" name="fine_motor" />
        <label>Social</label><textarea name="social" maxlength="255"></textarea>
        <label>Language</label><textarea name="language"></textarea>
        <label>Summary</label><textarea name="summary"></textarea>
        <label>Plan</label><textarea name="plan"></textarea>
        <div style="text-align: center;">
            <button type="submit">Submit</button>
        </div>
    </form>