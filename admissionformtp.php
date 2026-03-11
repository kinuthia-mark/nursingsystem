<?php
require_once 'session.php';
require_once 'dbconnect.php';

// Post Logic Handler
$status_type = "";
$status_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Note: Add your specific $conn->prepare and bind_param logic here.
    // After successful save:
    // $status_type = "success";
    // $status_msg = "Patient record has been successfully admitted.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'head.php'; ?>
    <style>
        /* Form-Specific Architectural Tweaks */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-top: 1rem;
        }
        .section-title {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--primary);
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            padding-bottom: 12px;
            border-bottom: 2px solid #eff6ff;
        }
        .main-input {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.2s;
        }
        .main-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            outline: none;
        }
        .alert-toast {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
        }
        .alert-success { background: #dcfce7; color: var(--success); border: 1px solid #bbf7d0; }
        .alert-danger { background: #fee2e2; color: var(--danger); border: 1px solid #fecaca; }
    </style>
</head>
<body>

<div class="dashboard-container">
    <?php include 'sidenav.php'; ?>

    <main class="main-content">
        <header class="top-bar">
            <div class="header-left" style="display:flex; align-items:center;">
                <button onclick="window.location.href='index.php'" class="btn-icon" style="background:none; border:none; cursor:pointer; font-size:1.2rem; color:var(--text-muted);">
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
                <span style="margin-left: 15px; font-weight: 700; color: var(--text-main);">Clinical Admission</span>
            </div>
            <div class="header-right">
                <div class="live-clock">
                    <i class="fa-regular fa-clock"></i>
                    <span id="digital-clock">00:00:00</span>
                </div>
            </div>
        </header>

        <div class="scroll-area">
            <?php if ($status_msg): ?>
                <div class="alert-toast alert-<?= $status_type ?>">
                    <i class="fa-solid <?= $status_type == 'success' ? 'fa-circle-check' : 'fa-circle-xmark' ?>"></i>
                    <?= $status_msg ?>
                </div>
            <?php endif; ?>

            <form action="admissionformtp.php" method="post">
                <div class="panel-header" style="margin-bottom: 2rem; border-bottom: none;">
                    <div>
                        <h1 style="font-size: 1.75rem; color: #0f172a;">New Patient Admission</h1>
                        <p style="color: var(--text-muted);">Please ensure all clinical data is verified before saving.</p>
                    </div>
                    <div class="header-actions" style="display:flex; gap:10px;">
                        <button type="button" class="btn-secondary" onclick="window.location.href='index.php'" style="background:#e2e8f0; border:none; padding:10px 20px; border-radius:8px; cursor:pointer;">Cancel</button>
                        <button type="submit" class="btn-primary"><i class="fa-solid fa-save"></i> Save Admission</button>
                    </div>
                </div>

                <div class="panel" style="margin-bottom: 2rem;">
                    <div class="section-title">
                        <i class="fa-solid fa-child-reaching"></i> Child Bio-Data
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="nav-label">Family Name</label>
                            <input type="text" name="family_name" class="main-input" placeholder="Enter surname" required>
                        </div>
                        <div class="form-group">
                            <label class="nav-label">First Name</label>
                            <input type="text" name="first_name" class="main-input" placeholder="Enter first name" required>
                        </div>
                        <div class="form-group">
                            <label class="nav-label">Sex</label>
                            <select name="sex" class="main-input" required>
                                <option value="">Select Sex</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="nav-label">Date of Birth</label>
                            <input type="date" id="dob" name="dob" class="main-input" required onchange="calculateAge()">
                        </div>
                        <div class="form-group">
                            <label class="nav-label">Age at Admission</label>
                            <input type="text" id="age_display" class="main-input" readonly placeholder="Calculated automatically" style="background:#f1f5f9;">
                            <input type="hidden" id="age_of_admission" name="age_of_admission">
                        </div>
                        <div class="form-group">
                            <label class="nav-label">Birth Weight (kg)</label>
                            <input type="number" step="0.01" name="birth_weight" class="main-input" placeholder="0.00" required>
                        </div>
                    </div>
                </div>

                <div class="panel" style="margin-bottom: 2rem;">
                    <div class="section-title">
                        <i class="fa-solid fa-users"></i> Family & Social History
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="nav-label">Mother's Life Status</label>
                            <select name="mother_life_status" class="main-input">
                                <option value="alive">Alive</option>
                                <option value="deceased">Deceased</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="nav-label">Mother's HIV Status</label>
                            <select name="mother_hiv_status" class="main-input">
                                <option value="negative">Negative</option>
                                <option value="positive">Positive</option>
                                <option value="unknown">Unknown</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="nav-label">Present Caretaker</label>
                            <input type="text" name="present_caretaker" class="main-input" placeholder="Relationship to child" required>
                        </div>
                    </div>
                </div>

                <div class="panel" style="border-left: 5px solid var(--danger);">
                    <div class="section-title" style="color: var(--danger);">
                        <i class="fa-solid fa-circle-exclamation"></i> Critical Admission Status
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="nav-label">Current Life Status</label>
                            <select id="child_life_status" name="child_life_status" class="main-input" onchange="toggleDeceased()">
                                <option value="alive">Alive</option>
                                <option value="deceased">Deceased</option>
                            </select>
                        </div>
                        <div id="death_date_group" class="form-group" style="display:none;">
                            <label class="nav-label">Date of Death</label>
                            <input type="date" name="date_of_death" class="main-input">
                        </div>
                        <div id="death_cause_group" class="form-group" style="display:none;">
                            <label class="nav-label">Cause of Death</label>
                            <input type="text" name="cause_of_death" class="main-input" placeholder="Specify clinical cause">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>

<script>
    // 1. Clinical Clock
    function updateClock() {
        const el = document.getElementById('digital-clock');
        if (el) el.textContent = new Date().toLocaleTimeString('en-GB');
    }
    setInterval(updateClock, 1000);
    updateClock();

    // 2. Advanced Age Calculation (Years/Months)
    function calculateAge() {
        const dobVal = document.getElementById('dob').value;
        if (!dobVal) return;

        const birthDate = new Date(dobVal);
        const today = new Date();
        
        let years = today.getFullYear() - birthDate.getFullYear();
        let months = today.getMonth() - birthDate.getMonth();
        
        if (months < 0 || (months === 0 && today.getDate() < birthDate.getDate())) {
            years--;
            months += 12;
        }

        const display = years > 0 ? `${years} Years, ${months} Months` : `${months} Months`;
        document.getElementById('age_display').value = display;
        document.getElementById('age_of_admission').value = years; // Numeric value for DB
    }

    // 3. UI Toggle for Mortality Fields
    function toggleDeceased() {
        const status = document.getElementById('child_life_status').value;
        const isDeceased = (status === 'deceased');
        
        document.getElementById('death_date_group').style.display = isDeceased ? 'block' : 'none';
        document.getElementById('death_cause_group').style.display = isDeceased ? 'block' : 'none';
    }
</script>
</body>
</html>