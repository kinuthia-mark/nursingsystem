<?php
require_once 'session.php';
require_once 'dbconnect.php';

$message = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $drug_name = trim($_POST['drug_name']);

    if (!empty($drug_name)) {
        $stmt = $conn->prepare("INSERT INTO drug_list (drug_name) VALUES (?)");
        $stmt->bind_param("s", $drug_name);

        if ($stmt->execute()) {
            $message = "<div class='alert-toast success'><i class='fa-solid fa-circle-check'></i> Medication added to repository.</div>";
        } else {
            $message = "<div class='alert-toast danger'><i class='fa-solid fa-circle-xmark'></i> Error: " . $stmt->error . "</div>";
        }
        $stmt->close();
    } else {
        $message = "<div class='alert-toast warning'><i class='fa-solid fa-triangle-exclamation'></i> Drug name cannot be empty.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'head.php'; ?>
    <style>
        /* Specific Inventory Styles */
        .inventory-wrapper {
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            gap: 2rem;
            margin-top: 1rem;
        }

        .medication-card {
            background: white;
            padding: 1rem;
            border-radius: 12px;
            border-left: 4px solid var(--success);
            box-shadow: var(--shadow-sm);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .alert-toast {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
            font-size: 0.9rem;
        }
        .success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        .warning { background: #fef9c3; color: #854d0e; border: 1px solid #fef08a; }

        .form-group label {
            display: block;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 8px;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <?php include 'sidenav.php'; ?>

    <main class="main-content">
        <header class="top-bar">
            <div class="search-wrapper">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="globalSearch" placeholder="Search pharmacy repository...">
            </div>
            <div class="header-right">
                <div class="live-clock">
                    <i class="fa-regular fa-clock"></i> 
                    <span id="digital-clock">00:00:00</span>
                </div>
            </div>
        </header>

        <div class="scroll-area">
            <div class="content-header">
                <div class="header-text">
                    <h1>Pharmacy Entry</h1>
                    <p>Register new medication into the institutional drug repository.</p>
                </div>
                <div class="header-actions">
                    <a href="index.php" class="btn-secondary" style="text-decoration:none;">
                        <i class="fa-solid fa-house"></i> Dashboard
                    </a>
                </div>
            </div>

            <div class="inventory-wrapper">
                
                <div class="panel" style="width: 100%; max-width: 650px;">
                    <div class="panel-header" style="border-bottom: 1px solid var(--border); margin-bottom: 20px; padding-bottom: 15px;">
                        <h3><i class="fa-solid fa-pills" style="color: var(--primary);"></i> Register New Drug</h3>
                    </div>
                    
                    <?= $message; ?>

                    <form method="post">
                        <div class="form-group" style="margin-bottom: 24px;">
                            <label>Generic / Brand Name</label>
                            <input type="text" name="drug_name" class="main-input" 
                                   placeholder="e.g. Paracetamol 500mg" required autofocus 
                                   style="width: 100%; padding: 14px; border-radius: 10px; border: 1px solid var(--border);">
                            <p style="color: var(--text-muted); font-size: 0.75rem; margin-top: 10px;">
                                <i class="fa-solid fa-circle-info"></i> Please cross-check spelling with the physical packaging before saving.
                            </p>
                        </div>
                        
                        <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; padding: 14px;">
                            <i class="fa-solid fa-plus-circle"></i> Add to Inventory
                        </button>
                    </form>
                </div>

                <div class="panel" style="width: 100%; max-width: 650px;">
                    <div class="panel-header" style="margin-bottom: 15px;">
                        <h3>Recently Added</h3>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1rem;">
                        <?php
                        $result = $conn->query("SELECT drug_name FROM drug_list ORDER BY id DESC LIMIT 4");
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "
                                <div class='medication-card'>
                                    <div>
                                        <div style='font-weight: 700; color: var(--text-main);'>" . htmlspecialchars($row['drug_name']) . "</div>
                                        <small style='color: var(--success); font-weight: 600;'>
                                            <i class='fa-solid fa-check'></i> Verified
                                        </small>
                                    </div>
                                    <i class='fa-solid fa-capsules' style='color: #e2e8f0; font-size: 1.2rem;'></i>
                                </div>";
                            }
                        } else {
                            echo "<p style='color:var(--text-muted); font-size:0.9rem;'>No drugs registered yet.</p>";
                        }
                        ?>
                    </div>
                </div>

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