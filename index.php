<?php
include 'session.php'; 
include 'dbconnect.php'; 
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
                <div class="search-container">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="globalSearch" placeholder="Search Patient ID... (Press '/' to focus)">
                </div>

                <div class="header-right">
                    <div class="live-clock">
                        <i class="fa-regular fa-clock"></i>
                        <span id="digital-clock">00:00:00</span>
                    </div>

                    <div class="notification-wrapper">
                        <button class="notification-btn" onclick="toggleNotifications()">
                            <i class="fa-solid fa-bell"></i>
                            <span class="badge">3</span>
                        </button>
                        <div id="notificationDropdown" class="dropdown-content">
                            <div class="dropdown-header">Clinical Alerts</div>
                            <div class="dropdown-item"><i class="fa-solid fa-circle-exclamation" style="color:var(--danger)"></i> HIV Test Pending: #C-1022</div>
                            <div class="dropdown-item"><i class="fa-solid fa-capsules" style="color:var(--warning)"></i> Med Update: Ward B</div>
                            <div class="dropdown-item"><i class="fa-solid fa-circle-check" style="color:var(--primary)"></i> Lab results: Baby Mary</div>
                        </div>
                    </div>
                </div>
            </header>

            <div class="scroll-area">
                <div class="content-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem;">
                    <div class="header-text">
                        <h1>Clinical Overview</h1>
                        <p>User: <strong><?= htmlspecialchars($_SESSION["username"]); ?></strong> | Ward Status: Active</p>
                    </div>
                    <div class="header-actions">
                        <button class="btn-secondary" onclick="window.print()"><i class="fa-solid fa-print"></i> Print Report</button>
                        <a href="admissionformtp.php" class="btn-primary" style="text-decoration:none;"><i class="fa-solid fa-plus"></i> New Admission</a>
                    </div>
                </div>

                <div class="metrics-grid">
                    <div class="metric-card primary">
                        <div class="metric-info"><h6>Total Children</h6><h3>142</h3><p>Registered Patients</p></div>
                        <i class="fa-solid fa-children icon-bg"></i>
                    </div>
                    <div class="metric-card danger">
                        <div class="metric-info"><h6>Tests Pending</h6><h3>12</h3><p>HIV Clearance Needed</p></div>
                        <i class="fa-solid fa-vial-virus icon-bg"></i>
                    </div>
                    <div class="metric-card warning">
                        <div class="metric-info"><h6>Medication Due</h6><h3>08</h3><p>In next 2 hours</p></div>
                        <i class="fa-solid fa-clock-rotate-left icon-bg"></i>
                    </div>
                    <div class="metric-card success">
                        <div class="metric-info"><h6>Active Nurses</h6><h3>05</h3><p>On-duty Staff</p></div>
                        <i class="fa-solid fa-user-nurse icon-bg"></i>
                    </div>
                </div>

                <div class="data-layout">
                    <div class="panel">
                        <div class="panel-header"><h3>Recent Admissions</h3></div>
                        <table class="clinical-table">
                            <thead>
                                <tr><th>Patient ID</th><th>Child Name</th><th>Age/Gender</th><th>Acuity</th><th>Action</th></tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT id, name, age, gender, status FROM children ORDER BY id DESC LIMIT 5";
                                $res = $conn->query($sql);
                                if ($res && $res->num_rows > 0) {
                                    while($row = $res->fetch_assoc()) {
                                        $initials = strtoupper(substr($row['name'], 0, 2));
                                        $statusClass = (strtolower($row['status']) == 'critical') ? 'critical' : 'stable';
                                        echo "<tr>
                                            <td>#C-{$row['id']}</td>
                                            <td><div class='patient-profile'><div class='avatar-sm'>{$initials}</div><span>".htmlspecialchars($row['name'])."</span></div></td>
                                            <td>{$row['age']} • {$row['gender']}</td>
                                            <td><span class='acuity-tag {$statusClass}'>{$row['status']}</span></td>
                                            <td><i class='fa-solid fa-chevron-right' style='color:var(--text-muted)'></i></td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5' style='text-align:center; padding:20px; color:var(--text-muted)'>No recent admissions found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="panel">
                        <div class="panel-header"><h3>Quick Tasks</h3></div>
                        <div class="task-list">
                            <label class="task-item"><input type="checkbox"><div class="task-text"><span>Review HIV Test #1022</span><small>Due: 14:00</small></div></label>
                            <label class="task-item"><input type="checkbox"><div class="task-text"><span>Ward A Inventory Check</span><small>Due: 16:00</small></div></label>
                            <label class="task-item"><input type="checkbox"><div class="task-text"><span>Update Staff Rota</span><small>Due: 17:00</small></div></label>
                        </div>
                    </div>
                </div> 
            </div> 
        </main>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            document.getElementById('digital-clock').textContent = now.toLocaleTimeString();
        }
        setInterval(updateClock, 1000);
        updateClock();

        function toggleNotifications() {
            document.getElementById("notificationDropdown").classList.toggle("show");
        }

        window.onclick = function(e) {
            if (!e.target.closest('.notification-wrapper')) {
                document.getElementById("notificationDropdown").classList.remove("show");
            }
        }

        window.addEventListener('keydown', e => {
            if (e.key === '/') { 
                if(document.activeElement.tagName !== 'INPUT') {
                    e.preventDefault(); 
                    document.getElementById('globalSearch').focus(); 
                }
            }
        });
    </script>
</body>
</html>