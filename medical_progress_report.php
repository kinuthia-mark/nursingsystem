<?php
// error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'session.php';
include 'dbconnect.php';
include 'recognize.php'; 

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
        // ssddddss = string, string, double, double, double, double, string, string
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
    <style>
        /* Essential layout styles to make the panels look right */
        .data-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        .panel {
            background: white;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            height: 100%;
        }
        .panel-header {
            background: #f8fafc;
            padding: 12px 20px;
            border-bottom: 1px solid #e2e8f0;
        }
        .panel-header h3 {
            margin: 0;
            font-size: 1rem;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .live-clock {
            background: #f1f5f9;
            padding: 8px 16px;
            border-radius: 20px;
            color: #2563eb;
            font-weight: bold;
            font-family: monospace;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .btn-primary {
            background: #2563eb;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            transition: background 0.2s;
        }
        .btn-primary:hover { background: #1d4ed8; }
        
        @media (max-width: 768px) {
            .data-layout { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <?php include 'sidenav.php'; ?>

    <main class="main-content">
        <header class="top-bar" style="display:flex; justify-content:space-between; align-items:center; padding: 1rem 2rem; background:white; border-bottom:1px solid #e2e8f0;">
            <div class="search-placeholder">
                </div> 
            <div class="header-right" style="display:flex; align-items:center; gap: 20px;">
                <div class="live-clock">
                    <i class="fa-regular fa-clock"></i>
                    <span id="digital-clock">00:00:00</span>
                </div>

            
            </div>
        </header>

        <div class="scroll-area" style="padding: 2rem;">
            <section class="content-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem;">
                <div>
                    <h1 style="font-size: 1.75rem; color: #0f172a; margin:0;">Clinical Progress Notes</h1>
                    <p style="color: #64748b; margin-top:5px;">Clinician: <strong><?= htmlspecialchars($_SESSION["username"]); ?></strong></p>
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
                            <div class="mb-3" style="margin-bottom: 1rem;">
                                <label class="form-label" style="display:block; font-weight:600; margin-bottom:5px;">Input Date:</label>
                                <input type="date" name="input_date" class="form-control" value="<?= date('Y-m-d') ?>" required style="width:100%; padding:8px; border:1px solid #cbd5e1; border-radius:4px;">
                            </div>
                            
                            <div class="row g-3" style="display:grid; grid-template-columns: 1fr 1fr; gap:15px;">
                                <div>
                                    <label class="form-label" style="display:block; font-weight:600; margin-bottom:5px;">WT (kg):</label>
                                    <input type="number" step="0.01" name="WT" class="form-control" placeholder="Weight" required style="width:100%; padding:8px; border:1px solid #cbd5e1; border-radius:4px;">
                                </div>
                                <div>
                                    <label class="form-label" style="display:block; font-weight:600; margin-bottom:5px;">HT (cm):</label>
                                    <input type="number" step="0.01" name="HT" class="form-control" placeholder="Height" required style="width:100%; padding:8px; border:1px solid #cbd5e1; border-radius:4px;">
                                </div>
                                <div>
                                    <label class="form-label" style="display:block; font-weight:600; margin-bottom:5px;">HC (cm):</label>
                                    <input type="number" step="0.01" name="HC" class="form-control" placeholder="Head Circ." required style="width:100%; padding:8px; border:1px solid #cbd5e1; border-radius:4px;">
                                </div>
                                <div>
                                    <label class="form-label" style="display:block; font-weight:600; margin-bottom:5px;">Temp (°C):</label>
                                    <input type="number" step="0.01" name="Temp" class="form-control" placeholder="Temp" required style="width:100%; padding:8px; border:1px solid #cbd5e1; border-radius:4px;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-header"><h3>History</h3></div>
                        <div style="padding: 1.5rem; height: calc(100% - 60px);">
                            <textarea name="history" class="form-control" rows="8" placeholder="Enter history details here..." required style="width:100%; height: 100%; min-height: 180px; padding:10px; border:1px solid #cbd5e1; border-radius:4px;"></textarea>
                        </div>
                    </div>
                </div>

                <div class="panel" style="margin-top: 2rem;">
                    <div class="panel-header"><h3>Diagnosis</h3></div>
                    <div style="padding: 1.5rem;">
                        <textarea name="diagnosis" class="form-control" rows="3" placeholder="Enter diagnosis..." required style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:4px;"></textarea>
                    </div>
                </div>

                <div class="panel" style="margin-top: 2rem;">
                    <div class="panel-header"><h3>Plan</h3></div>
                    <div style="padding: 1.5rem;">
                        <textarea name="plan" class="form-control" rows="5" placeholder="Enter management plan..." required style="width:100%; padding:10px; border:1px solid #cbd5e1; border-radius:4px;"></textarea>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>

<script>
    /**
     * THE CLOCK
     * Updates every second using local British format (24hr)
     */
    function runClock() {
        const el = document.getElementById('digital-clock');
        if (el) {
            const now = new Date();
            // Manual padding ensures it never looks like 9:5:2
            const h = String(now.getHours()).padStart(2, '0');
            const m = String(now.getMinutes()).padStart(2, '0');
            const s = String(now.getSeconds()).padStart(2, '0');
            el.textContent = h + ":" + m + ":" + s;
        }
    }
    
    // Start immediately
    runClock();
    // Update every 1000ms
    setInterval(runClock, 1000);
</script>

</body>
</html>