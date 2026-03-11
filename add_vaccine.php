<?php
require_once 'session.php';
require_once 'dbconnect.php';

$message = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vaccine_name = trim($_POST['vaccine_name']);

    if (!empty($vaccine_name)) {
        $stmt = $conn->prepare("INSERT INTO vaccine_list (vaccine_name) VALUES (?)");
        $stmt->bind_param("s", $vaccine_name);

        if ($stmt->execute()) {
            $message = "<div class='alert-toast success'><i class='fa-solid fa-circle-check'></i> Vaccine successfully registered in the system.</div>";
        } else {
            $message = "<div class='alert-toast danger'><i class='fa-solid fa-circle-xmark'></i> Database Error: " . $stmt->error . "</div>";
        }
        $stmt->close();
    } else {
        $message = "<div class='alert-toast warning'><i class='fa-solid fa-triangle-exclamation'></i> Please provide a valid vaccine name.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'head.php'; ?>
    <link rel="stylesheet" href="stylev2.css">
    <style>
        /* Ensuring consistent UI hierarchy */
        .vaccine-layout {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2rem;
            margin-top: 1.5rem;
        }

        .alert-toast {
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            font-size: 0.9rem;
            animation: fadeIn 0.3s ease;
        }
        .success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        .warning { background: #fef9c3; color: #854d0e; border: 1px solid #fef08a; }

        .inventory-card {
            background: white;
            padding: 1.2rem;
            border-radius: 12px;
            border-left: 5px solid var(--primary);
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(-5px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body>

<div class="dashboard-container">
    <?php include 'sidenav.php'; ?>

    <main class="main-content">
        <header class="top-bar">
            <div class="header-left">
                <button onclick="window.location.href='index.php'" class="btn-icon" style="background:none; border:none; cursor:pointer; color:var(--text-muted);">
                    <i class="fa-solid fa-house-medical"></i>
                </button>
                <span style="margin-left: 10px; font-weight: 700; color: var(--text-main);">Immunization Repository</span>
            </div>
            <div class="header-right">
                <div class="live-clock"><i class="fa-regular fa-clock"></i> <span id="digital-clock">00:00:00</span></div>
            </div>
        </header>

        <div class="scroll-area">
            <div class="content-header">
                <div class="header-text">
                    <h1>Add New Vaccine</h1>
                    <p>Register immunization stocks and types for pediatric care.</p>
                </div>
            </div>

            <div class="vaccine-layout">
                
                <div class="panel" style="width: 100%; max-width: 600px;">
                    <div class="panel-header" style="border-bottom: 1px solid var(--border); margin-bottom: 25px; padding-bottom: 15px;">
                        <h3><i class="fa-solid fa-syringe" style="color: var(--primary);"></i> Vaccine Details</h3>
                    </div>
                    
                    <?= $message; ?>

                    <form method="post">
                        <div class="form-group" style="margin-bottom: 25px;">
                            <label class="nav-label">Vaccine Name / Dosage Code</label>
                            <input type="text" name="vaccine_name" class="main-input" 
                                   placeholder="e.g. BCG, OPV-0, Pentavalent" required autofocus 
                                   style="width: 100%; padding: 14px; border-radius: 10px; border: 1px solid var(--border);">
                            <p style="color: var(--text-muted); font-size: 0.75rem; margin-top: 10px;">
                                <i class="fa-solid fa-info-circle"></i> Use standard medical abbreviations for consistency.
                            </p>
                        </div>
                        
                        <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; height: 50px;">
                            <i class="fa-solid fa-plus-circle"></i> Register Vaccine
                        </button>
                    </form>
                </div>

                <div class="panel" style="width: 100%; max-width: 600px;">
                    <div class="panel-header" style="margin-bottom: 15px;">
                        <h3>Active Vaccine List</h3>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1rem;">
                        <?php
                        $result = $conn->query("SELECT vaccine_name FROM vaccine_list ORDER BY id DESC LIMIT 6");
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "
                                <div class='inventory-card'>
                                    <div>
                                        <div style='font-weight: 700; color: var(--text-main);'>" . htmlspecialchars($row['vaccine_name']) . "</div>
                                        <small style='color: var(--primary); font-weight: 600;'>Cataloged</small>
                                    </div>
                                    <i class='fa-solid fa-vial' style='color: #cbd5e1;'></i>
                                </div>";
                            }
                        } else {
                            echo "<p style='color:var(--text-muted);'>No vaccines registered.</p>";
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