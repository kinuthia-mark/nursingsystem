<?php
include 'session.php';
include 'dbconnect.php';

$message = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $drug_name = trim($_POST['drug_name']);

    if (!empty($drug_name)) {
        $stmt = $conn->prepare("INSERT INTO drug_list (drug_name) VALUES (?)");
        $stmt->bind_param("s", $drug_name);

        if ($stmt->execute()) {
            $message = "<div class='alert-toast success'><i class='fa fa-check-circle'></i> Drug added successfully.</div>";
        } else {
            $message = "<div class='alert-toast error'><i class='fa fa-times-circle'></i> Error: " . $stmt->error . "</div>";
        }
        $stmt->close();
    } else {
        $message = "<div class='alert-toast warning'><i class='fa fa-exclamation-triangle'></i> Drug name cannot be empty.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>N-DBMS | Add Medication</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="dashboard-container">
    <?php include 'sidenav.php'; ?>

    <main class="main-content">
        <header class="top-bar">
            <div class="search-container">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="globalSearch" placeholder="Quick search inventory...">
            </div>
            <div class="header-right">
                <div class="live-clock"><i class="fa-regular fa-clock"></i> <span id="digital-clock">00:00:00</span></div>
            </div>
        </header>

        <div class="scroll-area">
            <div class="content-header">
                <div class="header-text">
                    <h1>Drug Inventory</h1>
                    <p>Register new medication into the system repository</p>
                </div>
                <div class="header-actions">
                    <a href="index.php" class="btn-secondary" style="text-decoration:none;"><i class="fa-solid fa-arrow-left"></i> Dashboard</a>
                </div>
            </div>

            <div style="display: flex; flex-direction: column; align-items: center; gap: 30px;">
                
                <div class="panel" style="width: 100%; max-width: 600px;">
                    <div class="panel-header" style="border-bottom: 1px solid var(--border-color); margin-bottom: 20px; padding-bottom: 15px;">
                        <h3><i class="fa fa-pills" style="color: var(--primary); margin-right: 10px;"></i> New Medication Details</h3>
                    </div>
                    
                    <?= $message; ?>

                    <form method="post" class="clinical-form">
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem;">Drug Generic Name / Brand Name</label>
                            <input type="text" name="drug_name" class="main-input" placeholder="Enter drug name (e.g. Amoxicillin)" required autofocus 
                                   style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--border-color); outline: none;">
                            <small style="color: var(--text-muted); font-size: 0.8rem; display: block; margin-top: 8px;">
                                * Ensure correct spelling before saving to the master list.
                            </small>
                        </div>
                        
                        <div style="display: flex; gap: 10px;">
                            <button type="submit" class="btn-primary" style="flex: 2; justify-content: center;">
                                <i class="fa fa-save"></i> Save to Database
                            </button>
                        </div>
                    </form>
                </div>

                <div class="panel" style="width: 100%; max-width: 600px;">
                    <div class="panel-header">
                        <h3>Recently Added</h3>
                    </div>
                    <div class="metrics-grid" style="grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 15px; margin-bottom: 0;">
                        <?php
                        $result = $conn->query("SELECT drug_name FROM drug_list ORDER BY id DESC LIMIT 4");
                        while($row = $result->fetch_assoc()) {
                            echo "<div class='metric-card success' style='padding: 12px; border-left-width: 4px;'>
                                    <div class='metric-info'>
                                        <p style='font-weight: 700; font-size: 0.85rem; color: var(--text-main); margin: 0;'>".htmlspecialchars($row['drug_name'])."</p>
                                        <small style='color: var(--success);'>Active</small>
                                    </div>
                                  </div>";
                        }
                        ?>
                    </div>
                </div>

            </div> </div> </main>
</div>

<script>
    function updateClock() {
        const now = new Date();
        document.getElementById('digital-clock').textContent = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>

</body>
</html>