<?php
include 'session.php'; 
include 'dbconnect.php'; 
include 'recognize.php'; 

error_reporting(E_ALL);
ini_set('display_errors', 1);

$message = "";
$messageType = ""; 

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vaccine_no = $_POST['vaccine_no'];
    $vaccine = $_POST['vaccine'];
    $date_given = $_POST['date_given'];

    $stmt = $conn->prepare("INSERT INTO vaccination (vaccine_no, vaccine, date_given) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $vaccine_no, $vaccine, $date_given);

    if ($stmt->execute()) {
        $message = "Vaccination record saved successfully.";
        $messageType = "success";
    } else {
        $message = "Error: " . $stmt->error;
        $messageType = "danger";
    }
    $stmt->close();
}

// Get vaccine list for the dropdown
$vaccineOptions = "";
$result = $conn->query("SELECT vaccine_name FROM vaccine_list ORDER BY vaccine_name ASC");
while ($row = $result->fetch_assoc()) {
    $v_name = htmlspecialchars($row['vaccine_name']);
    $vaccineOptions .= "<option value=\"$v_name\">$v_name</option>";
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'; ?>
<style>
    /* Fixed Grid to prevent squashing */
    .vaccine-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }
    .form-group label {
        display: block;
        font-weight: 600;
        color: #475569;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }
    .custom-input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
    }
    @media (max-width: 768px) {
        .vaccine-grid { grid-template-columns: 1fr; }
    }
</style>
<body>

<div class="dashboard-container">
    <?php include 'sidenav.php'; ?>

    <main class="main-content">
        <header class="top-bar">
            <div class="search-placeholder"></div> 
            <div class="header-right">
                <div class="live-clock">
                    <i class="fa-regular fa-clock"></i>
                    <span id="digital-clock">00:00:00</span>
                </div>
            </div>
        </header>

        <div class="scroll-area">
            <section class="content-header" style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: flex-end;">
                <div>
                    <h1 style="font-size: 1.75rem; color: #0f172a;">Immunization Registry</h1>
                    <p style="color: #64748b;">Record and track patient vaccination history.</p>
                </div>
                <a href="add_vaccine.php" class="btn-light" style="padding: 10px 15px; border-radius: 8px; border: 1px solid #cbd5e1; background: #fff; text-decoration: none; color: #3b82f6; font-weight: 600; font-size: 0.85rem;">
                    <i class="fa-solid fa-plus-circle me-1"></i> Add New Vaccine Type
                </a>
            </section>

            <?php if ($message): ?>
                <div class="alert shadow-sm mb-4" style="padding: 1rem; border-radius: 12px; background: <?= $messageType == 'success' ? '#f0fdf4' : '#fef2f2' ?>; border: 1px solid <?= $messageType == 'success' ? '#bbf7d0' : '#fecaca' ?>; color: <?= $messageType == 'success' ? '#166534' : '#991b1b' ?>;">
                    <i class="fa-solid <?= $messageType == 'success' ? 'fa-circle-check' : 'fa-triangle-exclamation' ?> me-2"></i>
                    <?= $message; ?>
                </div>
            <?php endif; ?>

            <div class="data-layout">
                <div class="panel" style="width: 100%; max-width: 900px; background: #fff; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                    <div class="panel-header" style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0;">
                        <h3 style="margin:0; font-size: 1.1rem; font-weight: 700; color: #1e293b;">
                            <i class="fa-solid fa-syringe me-2" style="color: #3b82f6;"></i>Vaccination Entry
                        </h3>
                    </div>
                    
                    <div style="padding: 2.5rem;">
                        <form action="vaccination.php" method="post">
                            <div class="vaccine-grid">
                                <div class="form-group">
                                    <label>Vaccine No / Batch ID</label>
                                    <input type="text" name="vaccine_no" class="custom-input" placeholder="e.g. BATCH-2024-001" required>
                                </div>

                                <div class="form-group">
                                    <label>Select Vaccine</label>
                                    <select name="vaccine" class="custom-input" required>
                                        <option value="">-- Choose from List --</option>
                                        <?= $vaccineOptions ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Date Administered</label>
                                    <input type="date" name="date_given" class="custom-input" required>
                                </div>
                            </div>

                            <div style="margin-top: 2.5rem; border-top: 1px solid #e2e8f0; padding-top: 1.5rem; display: flex; justify-content: flex-end;">
                                <button type="submit" class="btn-primary" style="padding: 12px 40px; border-radius: 8px; border: none; background: #2563eb; color: white; font-weight: 700; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);">
                                    <i class="fa-solid fa-save me-2"></i> Save Vaccination Record
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    function runClock() {
        const el = document.getElementById('digital-clock');
        if (el) el.textContent = new Date().toLocaleTimeString('en-GB');
    }
    setInterval(runClock, 1000);
    runClock();
</script>

</body>
</html>