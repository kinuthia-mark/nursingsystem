<?php
// Get the current page name for active states
$current_page = basename($_SERVER['PHP_SELF']);
?>

<aside class="sidebar">
    <div class="logo">
        <i class="fa-solid fa-heart-pulse"></i>
        <span>N-<b>DBMS</b></span>
    </div>

    <nav class="sidebar-nav">
        <small class="nav-label">Clinical Operations</small>
        <ul>
            <li class="<?= ($current_page == 'index.php') ? 'active' : ''; ?>">
                <a href="index.php"><i class="fa-solid fa-gauge-high"></i> Dashboard</a>
            </li>
            <li class="<?= ($current_page == 'admissionformtp.php') ? 'active' : ''; ?>">
                <a href="admissionformtp.php"><i class="fa-solid fa-hospital-user"></i> Children Register</a>
            </li>
            <li class="<?= ($current_page == 'add_drug.php') ? 'active' : ''; ?>">
                <a href="add_drug.php"><i class="fa-solid fa-prescription-bottle-medical"></i> Pharmacy Entry</a>
            </li>
            <li class="<?= ($current_page == 'hiv_test.php') ? 'active' : ''; ?>">
                <a href="hiv_test.php">
                    <i class="fa-solid fa-microscope"></i> Diagnostic Tests
                    <span class="nav-badge" style="background: var(--danger); color: white; padding: 2px 8px; border-radius: 10px; font-size: 0.7rem; margin-left: auto;">3</span>
                </a>
            </li>
        </ul>

        <small class="nav-label">Records & Analytics</small>
        <ul>
            <li class="<?= ($current_page == 'master_list.php') ? 'active' : ''; ?>">
                <a href="master_list.php"><i class="fa-solid fa-clipboard-list"></i> Master Registry</a>
            </li>
            <li class="<?= ($current_page == 'medical_progress_report.php') ? 'active' : ''; ?>">
                <a href="medical_progress_report.php"><i class="fa-solid fa-file-waveform"></i> Progress Reports</a>
            </li>
        </ul>

        <small class="nav-label">Administrative Control</small>
        <ul>
            <li class="<?= ($current_page == 'user_register.php') ? 'active' : ''; ?>">
                <a href="user_register.php"><i class="fa-solid fa-user-gear"></i> Staff Management</a>
            </li>
            <li>
                <a href="#"><i class="fa-solid fa-sliders"></i> System Config</a>
            </li>
        </ul>
    </nav>

    <div class="sidebar-footer">
        <div class="user-profile-card">
            <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION["username"]); ?>&background=3b82f6&color=fff" alt="Avatar">
            <div class="user-details">
                <span class="u-name"><?= htmlspecialchars($_SESSION["username"]); ?></span>
                <span class="u-role">Medical Staff</span>
            </div>
            <a href="logout.php" class="logout-link" title="Logout">
                <i class="fa-solid fa-power-off"></i>
            </a>
        </div>
    </div>
</aside>