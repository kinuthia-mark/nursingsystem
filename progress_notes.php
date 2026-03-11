<?php
// error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'session.php';
include 'dbconnect.php';

$status_msg = "";

// handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_date = $_POST['input_date'];
    $history    = $_POST['history'];
    $WT         = $_POST['WT'];
    $HT         = $_POST['HT'];
    $HC         = $_POST['HC'];
    $Temp       = $_POST['Temp'];
    $diagnosis  = $_POST['diagnosis'];
    $plan       = $_POST['plan'];

    $stmt = $conn->prepare("INSERT INTO progress_notes 
    (input_date, history, WT, HT, HC, Temp, diagnosis, plan)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt) {
        $stmt->bind_param("ssddddss", $input_date, $history, $WT, $HT, $HC, $Temp, $diagnosis, $plan);
        if ($stmt->execute()) {
            $status_msg = "✅ Progress note saved successfully.";
        } else {
            $status_msg = "❌ Error executing: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $status_msg = "❌ Prepare failed: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'head.php'; ?>
</head>
<body>

<div class="dashboard-container">
    <?php include 'sidenav.php'; ?>

    <main class="main-content">
        <header class="top-bar">
            <div class="search-placeholder"></div> <div class="header-right">
                <div class="live-clock">
                    <i class="fa-regular fa-clock"></i>
                    <span id="digital-clock">00:00:00</span>
                </div>

                <div class="notification-wrapper">
                    <button type="button" class="notification-trigger">
                        <i class="fa-solid fa-bell"></i>
                    </button>
                </div>
            </div>
        </header>

        <div class="scroll-area">
            <section class="content-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem;">
                <div>
                    <h1 style="font-size: 1.75rem; color: #0f172a;">Clinical Progress Notes</h1>
                    <p style="color: var(--text-muted);">Clinician: <strong><?= htmlspecialchars($_SESSION["username"]); ?></strong></p>
                </div>
                <div class="header-actions">
                    <button type="submit" form="progressNotesForm" class="btn-primary" style="border:none; cursor:pointer;">
                        <i class="fa-solid fa-file-export"></i> Save Note
                    </button>
                </div>
            </section>

            <?php if ($status_msg): ?>
                <div class="alert shadow-sm mb-4" style="padding: 1rem; border-radius: 8px; background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0;">
                    <?= $status_msg ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="" id="progressNotesForm">
                <div class="data-layout">
                    
                    <div class="panel">
                        <div class="panel-header"><h3>Vitals & Info</h3></div>
                        <div style="padding: 1.5rem;">
                            <div class="mb-3">
                                <label class="form-label">Input Date:</label>
                                <input type="date" name="input_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                            </div>
                            
                            <div class="row g-3">
                                <div class="col-6">
                                    <label class="form-label">WT (kg):</label>
                                    <input type="number" step="0.01" name="WT" class="form-control" placeholder="Weight" required>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">HT (cm):</label>
                                    <input type="number" step="0.01" name="HT" class="form-control" placeholder="Height" required>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">HC (cm):</label>
                                    <input type="number" step="0.01" name="HC" class="form-control" placeholder="Head Circ." required>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Temp (°C):</label>
                                    <input type="number" step="0.01" name="Temp" class="form-control" placeholder="Temp" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-header"><h3>History</h3></div>
                        <div style="padding: 1.5rem;">
                            <textarea name="history" class="form-control" rows="8" placeholder="Enter history details here..." required style="height: 100%; min-height: 180px;"></textarea>
                        </div>
                    </div>
                </div>

                <div class="panel" style="margin-top: 2rem;">
                    <div class="panel-header"><h3>Diagnosis</h3></div>
                    <div style="padding: 1.5rem;">
                        <textarea name="diagnosis" class="form-control" rows="3" placeholder="Enter diagnosis..." required></textarea>
                    </div>
                </div>

                <div class="panel" style="margin-top: 2rem;">
                    <div class="panel-header"><h3>Plan</h3></div>
                    <div style="padding: 1.5rem;">
                        <textarea name="plan" class="form-control" rows="5" placeholder="Enter management plan..." required></textarea>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>

<script>
    // THE CLOCK (Matching your dashboard logic)
    function runClock() {
        const el = document.getElementById('digital-clock');
        if (el) el.textContent = new Date().toLocaleTimeString('en-GB');
    }
    setInterval(runClock, 1000);
    runClock();
</script>

</body>
</html>