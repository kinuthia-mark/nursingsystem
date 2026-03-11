<?php
// Get the current page name for active states
$current_page = basename($_SERVER['PHP_SELF']);

// Fetch live counts for badges
$unread_notifs = 0;
if (isset($conn)) {
    $res = $conn->query("SELECT COUNT(*) as total FROM notifications WHERE is_read = 0");
    if ($res) {
        $unread_notifs = $res->fetch_assoc()['total'];
    }
}
?>

<aside class="sidebar">
    <div class="logo">
        <i class="fa-solid fa-heart-pulse"></i>
        <span>N-<b>DBMS</b></span>
    </div>

    <nav class="sidebar-nav">
        
        <small class="nav-label">Main</small>
        <ul>
            <li class="<?= ($current_page == 'index.php') ? 'active' : ''; ?>">
                <a href="index.php">
                    <i class="fa-solid fa-gauge-high"></i> 
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="<?= ($current_page == 'notifications.php') ? 'active' : ''; ?>">
                <a href="notifications.php">
                    <i class="fa-solid fa-bell"></i> 
                    <span>Notifications</span>
                    <?php if ($unread_notifs > 0): ?>
                        <span class="nav-badge"><?= $unread_notifs ?></span>
                    <?php endif; ?>
                </a>
            </li>
        </ul>

        <small class="nav-label">Clinical Operations</small>
        <ul>
            <li class="<?= ($current_page == 'admissionformtp.php') ? 'active' : ''; ?>">
                <a href="admissionformtp.php">
                    <i class="fa-solid fa-hospital-user"></i> 
                    <span>Children Register</span>
                </a>
            </li>
            <li class="<?= ($current_page == 'admission_examination.php') ? 'active' : ''; ?>">
                <a href="admission_examination.php">
                    <i class="fa-solid fa-notes-medical"></i> 
                    <span>Admission Exam</span>
                </a>
            </li>
            <li class="<?= ($current_page == 'laboratory.php') ? 'active' : ''; ?>">
                <a href="laboratory.php" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                    <span><i class="fa-solid fa-flask-vial"></i> Laboratory</span>
                    <?php
                        $lab_alerts = $conn->query("SELECT id FROM notifications WHERE title LIKE '%Lab%' AND is_read = 0 LIMIT 1");
                        if($lab_alerts && $lab_alerts->num_rows > 0) echo '<span class="status-dot"></span>';
                    ?>
                </a>
            </li>
            <li class="<?= ($current_page == 'hiv_test.php') ? 'active' : ''; ?>">
                <a href="hiv_test.php">
                    <i class="fa-solid fa-microscope"></i> 
                    <span>Diagnostic Tests</span>
                </a>
            </li>
            <li class="<?= ($current_page == 'add_drug.php') ? 'active' : ''; ?>">
                <a href="add_drug.php">
                    <i class="fa-solid fa-prescription-bottle-medical"></i> 
                    <span>Pharmacy Entry</span>
                </a>
            </li>
            <li class="<?= ($current_page == 'arv_therapy.php') ? 'active' : ''; ?>">
                <a href="arv_therapy.php">
                    <i class="fa-solid fa-pills"></i> 
                    <span>ARV Therapy</span>
                </a>
            </li>
            <li class="<?= ($current_page == 'add_vaccine.php') ? 'active' : ''; ?>">
                <a href="add_vaccine.php">
                    <i class="fa-solid fa-syringe"></i> 
                    <span>Vaccine Registry</span>
                </a>
            </li>
            <li class="<?= ($current_page == 'HIV_+ve_siblings.php') ? 'active' : ''; ?>">
                <a href="HIV_+ve_siblings.php">
                    <i class="fa-solid fa-people-group"></i> 
                    <span>+ve Siblings</span>
                </a>
            </li>
            <li class="<?= ($current_page == 'vaccination.php') ? 'active' : ''; ?>">
        <a href="vaccination.php">
            <i class="fa-solid fa-capsules"></i> 
            <span>Vaccination Entry</span>
        </a>
    </li>
        </ul>

        <small class="nav-label">Records & Analytics</small>
        <ul>
            <li class="<?= ($current_page == 'master_list.php') ? 'active' : ''; ?>">
                <a href="master_list.php">
                    <i class="fa-solid fa-clipboard-list"></i> 
                    <span>Master Registry</span>
                </a>
            </li>
            <li class="<?= ($current_page == 'medical_progress_report.php') ? 'active' : ''; ?>">
                <a href="medical_progress_report.php">
                    <i class="fa-solid fa-file-waveform"></i> 
                    <span>Progress Reports</span>
                </a>
            </li>
            <li class="<?= ($current_page == 'discharge_abstract.php') ? 'active' : ''; ?>">
                <a href="discharge_abstract.php">
                    <i class="fa-solid fa-file-export"></i> 
                    <span>Discharge Abstract</span>
                </a>
            </li>
        </ul>

        <small class="nav-label">Administration</small>
<ul>
    <li class="<?= ($current_page == 'user_register.php') ? 'active' : ''; ?>">
        <a href="user_register.php">
            <i class="fa-solid fa-user-gear"></i> 
            <span>Staff Management</span>
        </a>
    </li>

    <li class="<?= ($current_page == 'user_levels.php') ? 'active' : ''; ?>">
        <a href="user_levels.php">
            <i class="fa-solid fa-layer-group"></i> 
            <span>User Levels</span>
        </a>
    </li>
    
    <li class="<?= ($current_page == 'system_config.php') ? 'active' : ''; ?>">
        <a href="#">
            <i class="fa-solid fa-sliders"></i> 
            <span>System Config</span>
        </a>
    </li>
</ul>
    </nav>

    <div class="sidebar-footer">
        <div class="user-profile-card">
            <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION["username"] ?? 'User'); ?>&background=3b82f6&color=fff&bold=true" alt="Avatar">
            <div class="user-details">
                <span class="u-name"><?= htmlspecialchars($_SESSION["username"] ?? 'Staff'); ?></span>
                <span class="u-role"><?= htmlspecialchars($_SESSION["role"] ?? 'Medical Staff'); ?></span>
            </div>
            <a href="logout.php" class="logout-link" title="Logout" onclick="return confirmExit(event)">
                <i class="fa-solid fa-power-off"></i>
            </a>
        </div>
    </div>
</aside>

<script>
function confirmExit(e) {
    if (!confirm("Are you sure you want to sign out? Ensure all clinical data is saved.")) {
        e.preventDefault();
        return false;
    }
}
</script>

<style>
/* Essential Sidebar CSS Tweaks */
.status-dot {
    width: 8px;
    height: 8px;
    background: #ef4444;
    border-radius: 50%;
    box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.2);
}

.nav-badge {
    background: #2563eb;
    color: white;
    font-size: 0.65rem;
    padding: 2px 8px;
    border-radius: 10px;
    font-weight: 800;
}

.logout-link {
    margin-left: auto;
    color: #94a3b8;
    transition: 0.2s;
    padding: 5px;
    border-radius: 6px;
}

.logout-link:hover {
    background: #fee2e2;
    color: #ef4444;
}
</style>