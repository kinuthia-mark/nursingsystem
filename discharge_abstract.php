<?php
require_once 'session.php';
require_once 'dbconnect.php';
include 'recognize.php'; 

$status_msg = "";
$status_type = "";

// Handle form submission
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

    if ($stmt->execute()) {
        $status_type = "success";
        $status_msg = "Discharge summary finalized and saved successfully.";
    } else {
        $status_type = "danger";
        $status_msg = "Database Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'head.php'; ?>
    <style>
        /* Locking in the standardized formatting */
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

        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .section-divider {
            border-left: 5px solid #2563eb;
            background: #f8fafc;
            padding: 12px 20px;
            margin: 25px 0 15px 0;
            font-weight: 800;
            color: #2563eb;
            text-transform: uppercase;
            font-size: 0.85rem;
        }

        textarea.main-input {
            min-height: 100px;
            resize: vertical;
        }

        .btn-submit {
            background: #2563eb;
            color: white;
            padding: 14px 35px;
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
                <span style="font-weight: 700; color: #1e293b;"><i class="fa-solid fa-file-export"></i> Discharge Module</span>
            </div>
            <div class="header-right">
                <div class="live-clock"><i class="fa-regular fa-clock"></i> <span id="digital-clock">00:00:00</span></div>
            </div>
        </header>

        <div class="scroll-area" style="padding: 2rem;">
            <div class="content-header" style="margin-bottom: 2rem;">
                <h1 style="font-size: 1.8rem; font-weight: 800; color: #0f172a;">Discharge Abstract</h1>
                <p style="color: #64748b;">Standardized entry for pediatric diagnostic results and transition of care.</p>
            </div>

            <?php if ($status_msg): ?>
                <div style="padding: 15px; border-radius: 10px; margin-bottom: 25px; background: <?= $status_type == 'success' ? '#dcfce7' : '#fee2e2' ?>; color: <?= $status_type == 'success' ? '#166534' : '#991b1b' ?>; border: 1px solid <?= $status_type == 'success' ? '#bbf7d0' : '#fecaca' ?>;">
                    <i class="fa-solid <?= $status_type == 'success' ? 'fa-circle-check' : 'fa-circle-xmark' ?>"></i> <?= $status_msg ?>
                </div>
            <?php endif; ?>

            <div class="panel">
                <form action="discharge_abstract.php" method="POST">
                    
                    <div class="section-divider"><i class="fa-solid fa-calendar-check"></i> Vital Statistics & Reference</div>
                    <div class="grid-3">
                        <div>
                            <label class="form-label">Discharge Date</label>
                            <input type="date" name="discharge_date" class="main-input" required value="<?= date('Y-m-d') ?>">
                        </div>
                        <div>
                            <label class="form-label">Discharge Weight (Kg)</label>
                            <input type="number" name="discharge_weight" class="main-input" step="0.1" placeholder="0.0" required>
                        </div>
                        <div>
                            <label class="form-label">Discharge Height (cm)</label>
                            <input type="number" name="discharge_height" class="main-input" step="0.1" placeholder="0.0" required>
                        </div>
                    </div>

                    <div class="grid-3">
                        <div>
                            <label class="form-label">Treatment Adherence</label>
                            <input type="text" name="adherence" class="main-input" placeholder="e.g. Good, Fair, Poor" required>
                        </div>
                        <div>
                            <label class="form-label">Name of CCC</label>
                            <input type="text" name="ccc_name" class="main-input" placeholder="Comprehensive Care Centre" required>
                        </div>
                        <div>
                            <label class="form-label">Discharge Doctor</label>
                            <input type="text" name="discharge_doctor" class="main-input" placeholder="Attending Physician" required>
                        </div>
                    </div>

                    <div class="section-divider"><i class="fa-solid fa-book-medical"></i> Clinical Narrative</div>
                    
                    <div style="margin-bottom: 20px;">
                        <label class="form-label">Admission Summary</label>
                        <textarea name="admission" class="main-input" placeholder="Reason for admission and initial state..." required></textarea>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label class="form-label">Clinical Progress</label>
                        <textarea name="clinical_progress" class="main-input" placeholder="Key milestones during hospitalization..." required></textarea>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label class="form-label">Condition at Discharge</label>
                        <textarea name="condition_at_discharge" class="main-input" placeholder="Final clinical status and post-discharge plan..." required></textarea>
                    </div>

                    <div style="margin-top: 30px; display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid #f1f5f9; padding-top: 25px;">
                        <button type="reset" style="background:#f1f5f9; border:1px solid #e2e8f0; padding:12px 25px; border-radius:8px; font-weight:600; cursor:pointer;">Clear Form</button>
                        <button type="submit" class="btn-submit">
                            <i class="fa-solid fa-check-double"></i> Finalize Discharge
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