<?php
require_once 'session.php';
require_once 'dbconnect.php';
include 'recognize.php'; 

$status_msg = "";
$status_type = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $test_no     = trim($_POST['test_no']);
    $date_tested = $_POST['date_tested'];
    $age         = (int)$_POST['age'];
    $result      = $_POST['result'];
    $agency      = trim($_POST['agency']);

    if (!empty($test_no)) {
        $stmt = $conn->prepare("INSERT INTO hiv_test (test_no, date_tested, age, result, agency) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiss", $test_no, $date_tested, $age, $result, $agency);

        if ($stmt->execute()) {
            $status_type = "success";
            $status_msg = "Diagnostic record #$test_no saved successfully.";
        } else {
            $status_type = "danger";
            $status_msg = "System Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'head.php'; ?>
    <style>
        /* FORCED REFACTOR: Ensuring buttons and inputs match the Dashboard UI */
        :root {
            --primary-blue: #2563eb;
            --primary-hover: #1d4ed8;
            --bg-light: #f8fafc;
            --border-color: #e2e8f0;
            --text-dark: #1e293b;
        }

        .panel {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            margin-top: 1rem;
        }

        .main-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-family: inherit;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            background: #fff;
        }

        .main-input:focus {
            outline: none;
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .btn-primary {
            background: var(--primary-blue);
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
        }

        .btn-secondary {
            background: #fff;
            color: var(--text-dark);
            padding: 12px 24px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-secondary:hover {
            background: var(--bg-light);
            border-color: #cbd5e1;
        }

        .form-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            color: #64748b;
            margin-bottom: 8px;
            letter-spacing: 0.025em;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <?php include 'sidenav.php'; ?>

    <main class="main-content">
        <header class="top-bar">
            <div class="header-left">
                <button onclick="window.location.href='index.php'" class="btn-secondary" style="padding: 8px 12px;">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
                <span style="margin-left: 15px; font-weight: 700; color: var(--text-dark);">Lab Documentation</span>
            </div>
            <div class="header-right">
                <div class="live-clock"><i class="fa-regular fa-clock"></i> <span id="digital-clock">00:00:00</span></div>
            </div>
        </header>

        <div class="scroll-area">
            <div class="content-header">
                <div class="header-text">
                    <h1>HIV Test Documentation</h1>
                    <p>Standardized entry for pediatric diagnostic results.</p>
                </div>
            </div>

            <div class="panel">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 2rem; color: var(--primary-blue);">
                    <i class="fa-solid fa-flask-vial" style="font-size: 1.5rem;"></i>
                    <h3 style="margin: 0; color: var(--text-dark);">Clinical Findings Form</h3>
                </div>

                <form action="hiv_test.php" method="post">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Lab Reference #</label>
                            <input type="text" name="test_no" class="main-input" placeholder="e.g. HIV-9901" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Date of Test</label>
                            <input type="date" name="date_tested" class="main-input" value="<?= date('Y-m-d') ?>" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Patient Age (Years)</label>
                            <input type="number" name="age" class="main-input" placeholder="Current age" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Clinical Result</label>
                            <select name="result" class="main-input" required>
                                <option value="">-- Choose Result --</option>
                                <option value="Negative">Negative (-)</option>
                                <option value="Positive">Positive (+)</option>
                                <option value="Unknown">Unknown/Inconclusive</option>
                            </select> 
                        </div>

                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label class="form-label">Testing Agency / Laboratory</label>
                            <input type="text" name="agency" class="main-input" placeholder="Facility name" required>
                        </div>
                    </div>

                    <div style="margin-top: 3rem; display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid var(--border-color); padding-top: 2rem;">
                        <button type="reset" class="btn-secondary">Clear Form</button>
                        <button type="submit" class="btn-primary">
                            <i class="fa-solid fa-save"></i> Commit Result
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