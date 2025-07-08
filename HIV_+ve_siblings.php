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
// Close the database connection

?>
<!DOCTYPE html>
<head>
    <title>HIV +ve siblings</title>
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
    
    <form action="HIV_+ve_siblings.php" method="post">
        <section>
            <h1 class="login-title">Siblings Information</h1>
            <label for="siblings_no">Siblings No:</label>
            <input type="number" id="siblings_no" name="siblings_no" min="0"><br>

            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name"><br>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name"><br>

            <label for="age">Age:</label>
            <input type="number" id="age" name="age" min="0"><br>

            <label for="sibling_sex">Sex:</label>
            <select id="sibling_sex" name="sibling_sex">
                <option value="">Select</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select><br>
        </section>
        <button type="submit">Submit</button>
    </form>
</body>
