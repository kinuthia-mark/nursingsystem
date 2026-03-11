<?php
require_once 'session.php';
require_once 'dbconnect.php';
include 'recognize.php'; 

$status_msg = "";
$status_type = "";

// 1. Process Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $drug1 = $_POST['drug_1'];
    $drug2 = $_POST['drug_2'];
    $drug3 = $_POST['drug_3'];
    $date_started = $_POST['date_started'];
    $date_stopped = !empty($_POST['date_stopped']) ? $_POST['date_stopped'] : null; 
    $reason = trim($_POST['reason']);
    $regimen = trim($_POST['regimen']);

    $stmt = $conn->prepare("INSERT INTO arv_therapy (drug_1, drug_2, drug_3, date_started, date_stopped, reason, regimen) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $drug1, $drug2, $drug3, $date_started, $date_stopped, $reason, $regimen);

    if ($stmt->execute()) {
        $status_type = "success";
        $status_msg = "ARV Therapy regimen updated successfully.";
    } else {
        $status_type = "danger";
        $status_msg = "Error: " . $stmt->error;
    }
    $stmt->close();
}

// 2. Fetch Drug Options for Dropdowns
$drugOptions = "";
$drug_result = $conn->query("SELECT drug_name FROM drug_list ORDER BY drug_name ASC");
while ($row = $drug_result->fetch_assoc()) {
    $d = htmlspecialchars($row['drug_name']);
    $drugOptions .= "<option value=\"$d\">$d</option>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'head.php'; ?>
    <style>
        /* CRITICAL STYLING FIXES */
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

        .therapy-box {
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
        }

        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
            padding: 12px 28px;
            border-radius: 8px;
            border: none;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: 0.2s;
        }

        .btn-primary:hover { background: #1d4ed8; }

        .btn-secondary {
            background: #f1f5f9;
            color: #475569;
            padding: 12px 20px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            font-weight: 600;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <?php include 'sidenav.php'; ?>

    <main class="main-content">
        <header class="top-bar">
            <div class="header-left">
                <span style="font-weight: 700; color: #1e293b;"><i class="fa-solid fa-pills"></i> Therapy Management</span>
            </div>
            <div class="header-right">
                <div class="live-clock"><i class="fa-regular fa-clock"></i> <span id="digital-clock">00:00:00</span></div>
            </div>
        </header>

        <div class="scroll-area" style="padding: 2rem;">
            <div class="content-header" style="margin-bottom: 2rem;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h1 style="font-size: 1.8rem; font-weight: 800; color: #0f172a; margin: 0;">Antiretroviral Therapy (ART)</h1>
                        <p style="color: #64748b; margin-top: 5px;">Manage medication combinations and treatment timelines.</p>
                    </div>
                    <a href="add_drug.php" style="color: #2563eb; font-weight: 700; text-decoration: none; font-size: 0.9rem;">
                        <i class="fa-solid fa-plus-circle"></i> Add New Drug Entry
                    </a>
                </div>
            </div>

            <?php if ($status_msg): ?>
                <div style="padding: 15px; border-radius: 10px; margin-bottom: 25px; background: <?= $status_type == 'success' ? '#dcfce7' : '#fee2e2' ?>; color: <?= $status_type == 'success' ? '#166534' : '#991b1b' ?>; border: 1px solid <?= $status_type == 'success' ? '#bbf7d0' : '#fecaca' ?>;">
                    <i class="fa-solid <?= $status_type == 'success' ? 'fa-circle-check' : 'fa-circle-xmark' ?>"></i> <?= $status_msg ?>
                </div>
            <?php endif; ?>

            <div class="panel">
                <form action="arv_therapy.php" method="post">
                    
                    <div class="form-label" style="margin-bottom: 15px;">Drug Combination (Triple Therapy)</div>
                    <div class="therapy-box">
                        <div class="grid-3">
                            <div>
                                <label class="form-label">Primary Drug (1)</label>
                                <select name="drug_1" class="main-input" required>
                                    <option value="">-- Select --</option>
                                    <?= $drugOptions ?>
                                </select>
                            </div>
                            <div>
                                <label class="form-label">Secondary Drug (2)</label>
                                <select name="drug_2" class="main-input" required>
                                    <option value="">-- Select --</option>
                                    <?= $drugOptions ?>
                                </select>
                            </div>
                            <div>
                                <label class="form-label">Tertiary Drug (3)</label>
                                <select name="drug_3" class="main-input" required>
                                    <option value="">-- Select --</option>
                                    <?= $drugOptions ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="grid-2">
                        <div>
                            <label class="form-label">Current Regimen Code</label>
                            <input type="text" name="regimen" class="main-input" placeholder="e.g. TDF/3TC/DTG" required>
                        </div>
                        <div>
                            <label class="form-label">Date Therapy Started</label>
                            <input type="date" name="date_started" class="main-input" value="<?= date('Y-m-d') ?>" required>
                        </div>
                    </div>

                    <div class="grid-2" style="margin-top: 20px;">
                        <div>
                            <label class="form-label">Date Therapy Stopped (Optional)</label>
                            <input type="date" name="date_stopped" class="main-input">
                        </div>
                        <div>
                            <label class="form-label">Reason for Stopping / Modification</label>
                            <textarea name="reason" class="main-input" style="height: 45px;" placeholder="Clinical notes..."></textarea>
                        </div>
                    </div>

                    <div style="margin-top: 40px; display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid #f1f5f9; padding-top: 25px;">
                        <button type="reset" class="btn-secondary">Clear Form</button>
                        <button type="submit" class="btn-primary">
                            <i class="fa-solid fa-save"></i> Save Therapy Record
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