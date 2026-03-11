<?php
require_once 'session.php';
require_once 'dbconnect.php';
include 'recognize.php'; 

$status_msg = "";
$status_type = "";

// 1. Process Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $age = intval($_POST['age']);
    $sibling_sex = $_POST['sibling_sex'];

    if ($first_name && $last_name && $age !== null && $sibling_sex) {
        // siblings_no is AUTO_INCREMENT in DB, so we omit it here
        $stmt = $conn->prepare("INSERT INTO hiv_positive_siblings (first_name, last_name, age, sex) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $first_name, $last_name, $age, $sibling_sex);

        if ($stmt->execute()) {
            $status_type = "success";
            $status_msg = "Sibling information for $first_name $last_name saved successfully.";
        } else {
            $status_type = "danger";
            $status_msg = "Error saving sibling information: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $status_type = "danger";
        $status_msg = "Please fill in all required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'head.php'; ?>
    <style>
        /* Standardized formatting lock-in */
        .panel {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            padding: 30px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .main-input {
            width: 100% !important;
            box-sizing: border-box !important;
            padding: 12px 15px !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 8px !important;
            font-size: 0.95rem !important;
            display: block !important;
        }

        .form-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            color: #64748b;
            margin-bottom: 8px;
            letter-spacing: 0.05em;
        }

        .grid-sibling {
            display: grid;
            grid-template-columns: 2fr 2fr 1fr 1fr;
            gap: 20px;
        }

        .btn-submit {
            background: #2563eb;
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            border: none;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: 0.2s;
        }

        .btn-submit:hover { background: #1d4ed8; }
    </style>
</head>
<body>

<div class="dashboard-container">
    <?php include 'sidenav.php'; ?>

    <main class="main-content">
        <header class="top-bar">
            <div class="header-left">
                <span style="font-weight: 700; color: #1e293b;"><i class="fa-solid fa-people-group"></i> Family Records</span>
            </div>
            <div class="header-right">
                <div class="live-clock"><i class="fa-regular fa-clock"></i> <span id="digital-clock">00:00:00</span></div>
            </div>
        </header>

        <div class="scroll-area" style="padding: 2rem;">
            <div class="content-header" style="margin-bottom: 2rem;">
                <h1 style="font-size: 1.8rem; font-weight: 800; color: #0f172a;">Sibling Health Information</h1>
                <p style="color: #64748b;">Registry for tracking HIV positive siblings to ensure family-centered care.</p>
            </div>

            <?php if ($status_msg): ?>
                <div style="padding: 15px; border-radius: 10px; margin-bottom: 25px; background: <?= $status_type == 'success' ? '#dcfce7' : '#fee2e2' ?>; color: <?= $status_type == 'success' ? '#166534' : '#991b1b' ?>; border: 1px solid <?= $status_type == 'success' ? '#bbf7d0' : '#fecaca' ?>;">
                    <i class="fa-solid <?= $status_type == 'success' ? 'fa-circle-check' : 'fa-circle-xmark' ?>"></i> <?= $status_msg ?>
                </div>
            <?php endif; ?>

            <div class="panel">
                <form action="HIV_+ve_siblings.php" method="post">
                    
                    <div class="form-label" style="margin-bottom: 15px; color: #2563eb;">Sibling Details</div>
                    
                    <div class="grid-sibling">
                        <div>
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" class="main-input" placeholder="Enter first name" required>
                        </div>
                        <div>
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="main-input" placeholder="Enter last name" required>
                        </div>
                        <div>
                            <label class="form-label">Age</label>
                            <input type="number" name="age" class="main-input" min="0" placeholder="0" required>
                        </div>
                        <div>
                            <label class="form-label">Sex</label>
                            <select name="sibling_sex" class="main-input" required>
                                <option value="">Select</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>

                    <div style="margin-top: 30px; display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid #f1f5f9; padding-top: 25px;">
                        <button type="reset" style="background:#f1f5f9; border:1px solid #e2e8f0; padding:12px 25px; border-radius:8px; font-weight:600; cursor:pointer;">Clear</button>
                        <button type="submit" class="btn-submit">
                            <i class="fa-solid fa-user-plus"></i> Add Sibling Record
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

<script>
    function updateClock() {
        const el = document.getElementById('digital-clock');
        if (el) el.textContent = new Date().toLocaleTimeString('en-GB');
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>

</body>
</html>