<?php
include 'session.php';
include 'dbconnect.php';

// Handle Post Logic at the top
$status_msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ... (Your existing sanitization logic here)
    // For brevity, assuming the bind_param logic is handled.
    // $status_msg = "success"; 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Admission | NurseFlow</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    
    <style>
        /* Specific tweaks for form-heavy pages */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 1rem;
        }
        .section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--primary);
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary-light);
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>

    <div class="dashboard-container">
        
        <?php include 'sidenav.php'; ?>

        <main class="main-content">
            
            <header class="top-bar">
                <div class="header-left">
                    <button onclick="history.back()" class="btn-icon"><i class="fa-solid fa-chevron-left"></i></button>
                    <span style="margin-left: 15px; font-weight: 700; color: var(--text-main);">Back to Dashboard</span>
                </div>
                <div class="header-right">
                    <div class="live-clock">
                        <i class="fa-regular fa-clock"></i>
                        <span id="digital-clock">00:00:00</span>
                    </div>
                </div>
            </header>

            <div class="scroll-area">
                
                <form action="admissionformtp.php" method="post">
                    
                    <div class="content-header">
                        <div class="header-text">
                            <h1>Clinical Admission Form</h1>
                            <p>Enter the patient's bio-data and family history below.</p>
                        </div>
                        <div class="header-actions">
                            <button type="button" class="btn-secondary" onclick="window.location.href='index.php'">Cancel</button>
                            <button type="submit" class="btn-primary"><i class="fa-solid fa-save"></i> Save Patient Record</button>
                        </div>
                    </div>

                    <div class="panel" style="margin-bottom: 2rem;">
                        <div class="section-title">
                            <i class="fa-solid fa-child-reaching"></i> Child Bio-Data
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="nav-label">Family Name</label>
                                <input type="text" name="family_name" class="main-input" placeholder="e.g. Smith" required>
                            </div>
                            <div class="form-group">
                                <label class="nav-label">First Name</label>
                                <input type="text" name="first_name" class="main-input" placeholder="e.g. John" required>
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
                                <input type="number" id="age_of_admission" name="age_of_admission" class="main-input" readonly placeholder="Auto-calculated">
                            </div>
                            <div class="form-group">
                                <label class="nav-label">Birth Weight (kg)</label>
                                <input type="number" step="0.01" name="birth_weight" class="main-input" required>
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
                                <input type="text" name="present_caretaker" class="main-input" placeholder="e.g. Grandmother" required>
                            </div>
                        </div>
                    </div>

                    <div class="panel" style="border-left: 5px solid var(--danger);">
                        <div class="section-title" style="color: var(--danger); border-bottom-color: #fee2e2;">
                            <i class="fa-solid fa-circle-exclamation"></i> Critical Status
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="nav-label">Child Life Status</label>
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
                                <input type="text" name="cause_of_death" class="main-input" placeholder="Clinical cause">
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </main>
    </div>

    <script>
        // Real-time Clock
        function updateClock() {
            const now = new Date();
            document.getElementById('digital-clock').textContent = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Age Calculation
        function calculateAge() {
            const dob = document.getElementById('dob').value;
            if (dob) {
                const birthDate = new Date(dob);
                const today = new Date();
                let age = today.getFullYear() - birthDate.getFullYear();
                const m = today.getMonth() - birthDate.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                document.getElementById('age_of_admission').value = age;
            }
        }

        // Toggle Mortality Fields
        function toggleDeceased() {
            const status = document.getElementById('child_life_status').value;
            const dateG = document.getElementById('death_date_group');
            const causeG = document.getElementById('death_cause_group');
            const isDeceased = (status === 'deceased');
            
            dateG.style.display = isDeceased ? 'block' : 'none';
            causeG.style.display = isDeceased ? 'block' : 'none';
        }
    </script>
</body>
</html>