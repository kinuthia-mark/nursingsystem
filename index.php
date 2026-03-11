<?php
require_once 'session.php';
require_once 'dbconnect.php';
require_once 'PatientRepository.php';

$repo = new PatientRepository($conn);
$patients = $repo->getRecentAdmissions(5);
$metrics = $repo->getDashboardMetrics();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'head.php'; ?>
</head>
<body>

<div class="dashboard-container">
    <?php include 'sidenav.php'; ?>

    <main class="main-content">
        <header class="top-bar">
            <div class="search-wrapper">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="globalSearch" placeholder="Search Patient ID... (Press '/' to focus)" autocomplete="off">
            </div>

            <div class="header-right">
                <div class="live-clock">
                    <i class="fa-regular fa-clock"></i>
                    <span id="digital-clock">00:00:00</span>
                </div>

                <div class="notification-wrapper">
    <?php 
    // Fetch top 5 unread notifications for the dropdown
    $unread_count_query = $conn->query("SELECT COUNT(*) as count FROM notifications WHERE is_read = 0");
    $unread_count = $unread_count_query->fetch_assoc()['count'];
    
    $live_notifs = $conn->query("SELECT * FROM notifications ORDER BY created_at DESC LIMIT 5");
    ?>
    
    <button type="button" class="notification-trigger" onclick="toggleNotifications()">
        <i class="fa-solid fa-bell"></i>
        <?php if($unread_count > 0): ?>
            <span class="badge"><?= $unread_count ?></span>
        <?php endif; ?>
    </button>
    
    <div id="notificationDropdown" class="dropdown-content">
        <div class="dropdown-header">Clinical Alerts (<?= $unread_count ?> Unread)</div>
        <div class="dropdown-body">
            <?php if ($live_notifs->num_rows > 0): ?>
                <?php while($n = $live_notifs->fetch_assoc()): 
                    $icon = ($n['category'] == 'Urgent') ? 'fa-circle-exclamation text-danger' : 'fa-info-circle text-primary';
                    $unread_style = ($n['is_read'] == 0) ? 'background: #f0f7ff; font-weight: 600;' : '';
                ?>
                    <div class="dropdown-item" style="<?= $unread_style ?> cursor: pointer;" onclick="window.location='notifications.php'">
                        <i class="fa-solid <?= $icon ?>"></i>
                        <div style="display: flex; flex-direction: column;">
                            <span style="font-size: 0.85rem;"><?= htmlspecialchars($n['title']) ?></span>
                            <small style="font-size: 0.7rem; color: #94a3b8;"><?= date('H:i', strtotime($n['created_at'])) ?></small>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="dropdown-item" style="color: #94a3b8; text-align: center; justify-content: center;">
                    <span>No recent alerts</span>
                </div>
            <?php endif; ?>
        </div>
        <div class="dropdown-footer" onclick="window.location='notifications.php'" style="padding:10px; text-align:center; font-size:0.8rem; border-top:1px solid var(--border); cursor:pointer; color:var(--primary);">
            View All Notifications
        </div>
    </div>
</div>
            </div>
        </header>

        <div class="scroll-area">
            <section class="content-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem;">
                <div>
                    <h1 style="font-size: 1.75rem; color: #0f172a;">Clinical Overview</h1>
                    <p style="color: var(--text-muted);">Nurse On Duty: <strong><?= htmlspecialchars($_SESSION["username"]); ?></strong></p>
                </div>
                <div class="header-actions">
                    <a href="admissionformtp.php" class="btn-primary" style="text-decoration:none;">
                        <i class="fa-solid fa-plus"></i> New Admission
                    </a>
                </div>
            </section>

            <div class="metrics-grid">
                <div class="metric-card primary">
                    <div class="metric-info"><h6>Total Children</h6><h3><?= $metrics['total_patients'] ?? '0' ?></h3></div>
                    <i class="fa-solid fa-children icon-bg"></i>
                </div>
                <div class="metric-card danger">
                    <div class="metric-info"><h6>Tests Pending</h6><h3>12</h3></div>
                    <i class="fa-solid fa-vial-virus icon-bg"></i>
                </div>
                <div class="metric-card warning">
                    <div class="metric-info"><h6>Medication Due</h6><h3>08</h3></div>
                    <i class="fa-solid fa-clock-rotate-left icon-bg"></i>
                </div>
                <div class="metric-card success">
                    <div class="metric-info"><h6>Active Nurses</h6><h3>05</h3></div>
                    <i class="fa-solid fa-user-nurse icon-bg"></i>
                </div>
            </div>

            <div class="data-layout">
                <div class="panel">
                    <div class="panel-header">
                        <h3>Recent Admissions</h3>
                        <a href="patient_list.php" class="view-all-btn" style="font-size: 0.8rem; color: var(--primary); font-weight: 600; text-decoration:none;">View All</a>
                    </div>
                    <table class="clinical-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NAME</th>
                                <th>DETAILS</th>
                                <th>ACUITY</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($patients as $row): 
                                $statusClass = (strtolower($row['status'] ?? '') == 'critical') ? 'danger' : 'stable';
                                $initials = strtoupper(substr($row['name'] ?? 'P', 0, 2));
                                $link = "view_patient.php?id=" . $row['id'];
                            ?>
                            <tr class="clickable-row" onclick="window.location='<?= $link ?>'" title="Click to view chart">
                                <td style="font-weight: 600;">#C-<?= $row['id'] ?></td>
                                <td>
                                    <div class="patient-profile">
                                        <div class="avatar-sm"><?= $initials ?></div>
                                        <span><?= htmlspecialchars($row['name'] ?? 'Unknown') ?></span>
                                    </div>
                                </td>
                                <td><?= $row['age'] ?? 'N/A' ?> • <?= $row['gender'] ?? 'N/A' ?></td>
                                <td><span class="acuity-tag <?= $statusClass ?>"><?= $row['status'] ?? 'Stable' ?></span></td>
                                <td style="text-align:right;">
                                    <i class="fa-solid fa-chevron-right" style="color:var(--primary); font-size:0.8rem;"></i>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="panel">
                    <div class="panel-header"><h3>Shift Tasks</h3></div>
                    <div class="task-list">
                        <label class="task-item">
                            <input type="checkbox">
                            <div class="task-body"><span>Review HIV Test #1022</span><time>Due 14:00</time></div>
                        </label>
                        <label class="task-item">
                            <input type="checkbox">
                            <div class="task-body"><span>Ward A Inventory Check</span><time>Due 16:00</time></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    // Toggle Notifications
    function toggleNotifications() {
        const dropdown = document.getElementById('notificationDropdown');
        if (dropdown) dropdown.classList.toggle('show');
    }

    // Global Click Handler
    document.addEventListener('click', function(e) {
        const wrap = document.querySelector('.notification-wrapper');
        const drop = document.getElementById('notificationDropdown');
        if (wrap && !wrap.contains(e.target)) drop.classList.remove('show');
    });

    // Search Focus (/)
    document.addEventListener('keydown', function(e) {
        if (e.key === '/' && document.activeElement.tagName !== 'INPUT') {
            e.preventDefault();
            document.getElementById('globalSearch').focus();
        }
    });

    // Medical Clock
    function runClock() {
        const el = document.getElementById('digital-clock');
        if (el) el.textContent = new Date().toLocaleTimeString('en-GB');
    }
    setInterval(runClock, 1000);
    runClock();
</script>
</body>
</html>