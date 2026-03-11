<?php
require_once 'session.php';
require_once 'dbconnect.php';
include 'recognize.php'; 

$status_msg = "";
$status_type = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize
    $test_date  = $_POST['testDate'];
    $cd4_count  = !empty($_POST['cd4Count']) ? $_POST['cd4Count'] : null;
    $cd4_perc   = !empty($_POST['cd4Perc']) ? $_POST['cd4Perc'] : null;
    $viral_load = !empty($_POST['viralLoad']) ? $_POST['viralLoad'] : null;
    $hb         = !empty($_POST['hb']) ? $_POST['hb'] : null;
    $ast        = !empty($_POST['ast']) ? $_POST['ast'] : null;
    $alt        = !empty($_POST['alt']) ? $_POST['alt'] : null;
    $trigly     = !empty($_POST['trigly']) ? $_POST['trigly'] : null;
    $cholest    = !empty($_POST['cholest']) ? $_POST['cholest'] : null;
    $ldl        = !empty($_POST['ldl']) ? $_POST['ldl'] : null;
    $hdl        = !empty($_POST['hdl']) ? $_POST['hdl'] : null;
    $creat      = !empty($_POST['creat']) ? $_POST['creat'] : null;

    $stmt = $conn->prepare("INSERT INTO laboratory_results (
        test_date, cd4_count, cd4_perc, viral_load, hb, ast, alt,
        total_trigly, total_cholest, ldl, hdl, creat
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sididiiiiiid", $test_date, $cd4_count, $cd4_perc, $viral_load, $hb, $ast, $alt, $trigly, $cholest, $ldl, $hdl, $creat);

    if ($stmt->execute()) {
        $status_type = "success";
        $status_msg = "Laboratory results saved successfully.";
        
        // Trigger a notification for the dashboard
        $notif_title = "Lab Results Updated";
        $notif_msg = "New results entered for Date: $test_date";
        $conn->query("INSERT INTO notifications (title, message, category) VALUES ('$notif_title', '$notif_msg', 'Clinical')");
        
    } else {
        $status_type = "danger";
        $status_msg = "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'head.php'; ?>
    <style>
        .panel { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 30px; }
        .main-input { width: 100% !important; box-sizing: border-box !important; padding: 10px 15px !important; border: 1px solid #cbd5e1 !important; border-radius: 8px !important; display: block !important; }
        .form-label { display: block; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; color: #64748b; margin-bottom: 8px; }
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 20px; }
        .lab-section-title { font-size: 0.85rem; font-weight: 700; color: #2563eb; background: #eff6ff; padding: 10px 15px; border-radius: 6px; margin: 20px 0 15px 0; border-left: 4px solid #2563eb; }
    </style>
</head>
<body>

<div class="dashboard-container">
    <?php include 'sidenav.php'; ?>

    <main class="main-content">
        <header class="top-bar">
            <div class="header-left"><span style="font-weight:700;"><i class="fa-solid fa-flask-vial"></i> Lab Investigation</span></div>
            <div class="header-right"><div class="live-clock"><i class="fa-regular fa-clock"></i> <span id="digital-clock">00:00:00</span></div></div>
        </header>

        <div class="scroll-area" style="padding: 2rem;">
            <div class="content-header" style="margin-bottom: 2rem;">
                <h1>Laboratory Results</h1>
                <p>Record hematological, biochemical, and virological markers.</p>
            </div>

            <?php if ($status_msg): ?>
                <div style="padding:15px; border-radius:10px; margin-bottom:25px; background:<?= $status_type=='success'?'#dcfce7':'#fee2e2'?>; color:<?= $status_type=='success'?'#166534':'#991b1b'?>;">
                    <i class="fa-solid fa-circle-check"></i> <?= $status_msg ?>
                </div>
            <?php endif; ?>

            <div class="panel">
                <form action="laboratory.php" method="post">
                    
                    <div class="grid-3">
                        <div>
                            <label class="form-label">Test Date</label>
                            <input type="date" name="testDate" class="main-input" required value="<?= date('Y-m-d') ?>">
                        </div>
                    </div>

                    <div class="lab-section-title">IMMUNOLOGY & VIROLOGY</div>
                    <div class="grid-3">
                        <div>
                            <label class="form-label">CD4 Count (cells/mm³)</label>
                            <input type="number" name="cd4Count" class="main-input">
                        </div>
                        <div>
                            <label class="form-label">CD4 Percentage (%)</label>
                            <input type="number" step="0.1" name="cd4Perc" class="main-input">
                        </div>
                        <div>
                            <label class="form-label">Viral Load (copies/ml)</label>
                            <input type="number" name="viralLoad" class="main-input">
                        </div>
                    </div>

                    <div class="lab-section-title">HEMATOLOGY & ORGAN FUNCTION</div>
                    <div class="grid-3">
                        <div>
                            <label class="form-label">Hemoglobin (HB) g/dL</label>
                            <input type="number" step="0.1" name="hb" class="main-input">
                        </div>
                        <div>
                            <label class="form-label">AST (U/L)</label>
                            <input type="number" name="ast" class="main-input">
                        </div>
                        <div>
                            <label class="form-label">ALT (U/L)</label>
                            <input type="number" name="alt" class="main-input">
                        </div>
                        <div>
                            <label class="form-label">Creatinine (μmol/L)</label>
                            <input type="number" step="0.01" name="creat" class="main-input">
                        </div>
                    </div>

                    <div class="lab-section-title">LIPID PROFILE</div>
                    <div class="grid-3">
                        <div>
                            <label class="form-label">Triglycerides (mmol/L)</label>
                            <input type="number" step="0.01" name="trigly" class="main-input">
                        </div>
                        <div>
                            <label class="form-label">Total Cholesterol</label>
                            <input type="number" step="0.01" name="cholest" class="main-input">
                        </div>
                        <div>
                            <label class="form-label">LDL</label>
                            <input type="number" step="0.01" name="ldl" class="main-input">
                        </div>
                        <div>
                            <label class="form-label">HDL</label>
                            <input type="number" step="0.01" name="hdl" class="main-input">
                        </div>
                    </div>

                    <div style="text-align: right; border-top: 1px solid #f1f5f9; padding-top: 25px; margin-top:20px;">
                        <button type="submit" class="btn-primary" style="padding: 12px 40px; border-radius: 8px; font-weight:700; background:#2563eb; color:#fff; border:none; cursor:pointer;">
                            <i class="fa-solid fa-flask"></i> Commit Results
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

<script>
    function updateClock() { document.getElementById('digital-clock').textContent = new Date().toLocaleTimeString('en-GB'); }
    setInterval(updateClock, 1000); updateClock();
</script>

</body>
</html>