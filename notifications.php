<?php
require_once 'session.php';
require_once 'dbconnect.php';

// Handle Mark as Read
if (isset($_GET['mark_read'])) {
    $id = intval($_GET['mark_read']);
    $conn->query("UPDATE notifications SET is_read = 1 WHERE id = $id");
    header("Location: notifications.php");
    exit();
}

// Fetch Notifications
$notif_query = $conn->query("SELECT * FROM notifications ORDER BY created_at DESC LIMIT 50");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'head.php'; ?>
    <style>
        .notif-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            display: flex;
            align-items: flex-start;
            gap: 20px;
            transition: 0.2s;
            position: relative;
        }
        
        .notif-card.unread {
            border-left: 5px solid #2563eb;
            background: #f8fafc;
        }

        .notif-icon {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .icon-clinical { background: #dbeafe; color: #2563eb; }
        .icon-urgent { background: #fee2e2; color: #dc2626; }
        .icon-system { background: #f1f5f9; color: #64748b; }

        .notif-content { flex-grow: 1; }
        .notif-title { font-weight: 800; color: #1e293b; margin-bottom: 4px; font-size: 1rem; }
        .notif-text { color: #64748b; font-size: 0.9rem; line-height: 1.4; }
        .notif-time { font-size: 0.75rem; color: #94a3b8; margin-top: 10px; font-weight: 600; }

        .btn-read {
            background: #f1f5f9;
            color: #475569;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
        }
        
        .btn-read:hover { background: #e2e8f0; }

        .empty-state {
            text-align: center;
            padding: 60px;
            color: #94a3b8;
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <?php include 'sidenav.php'; ?>

    <main class="main-content">
        <header class="top-bar">
            <div class="header-left">
                <span style="font-weight: 700; color: #1e293b;"><i class="fa-solid fa-bell"></i> Notification Center</span>
            </div>
            <div class="header-right">
                <div class="live-clock"><i class="fa-regular fa-clock"></i> <span id="digital-clock">00:00:00</span></div>
            </div>
        </header>

        <div class="scroll-area" style="padding: 2rem;">
            <div class="content-header" style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h1 style="font-size: 1.8rem; font-weight: 800; color: #0f172a;">Alerts & Updates</h1>
                    <p style="color: #64748b;">Review system alerts, patient milestones, and clinical tasks.</p>
                </div>
                <div class="badge" style="background: #2563eb; color: white; padding: 8px 16px; border-radius: 20px; font-weight: 700;">
                    Latest 50 entries
                </div>
            </div>

            <div class="notif-list">
                <?php if ($notif_query->num_rows > 0): ?>
                    <?php while($row = $notif_query->fetch_assoc()): 
                        $cat_class = "icon-" . strtolower($row['category']);
                        $icon = ($row['category'] == 'Urgent') ? 'fa-triangle-exclamation' : 'fa-info-circle';
                        if($row['category'] == 'Clinical') $icon = 'fa-stethoscope';
                    ?>
                        <div class="notif-card <?= $row['is_read'] == 0 ? 'unread' : '' ?>">
                            <div class="notif-icon <?= $cat_class ?>">
                                <i class="fa-solid <?= $icon ?>"></i>
                            </div>
                            <div class="notif-content">
                                <div class="notif-title"><?= htmlspecialchars($row['title']) ?></div>
                                <div class="notif-text"><?= htmlspecialchars($row['message']) ?></div>
                                <div class="notif-time">
                                    <i class="fa-regular fa-calendar"></i> <?= date('d M, Y | H:i', strtotime($row['created_at'])) ?>
                                </div>
                            </div>
                            <?php if($row['is_read'] == 0): ?>
                                <a href="notifications.php?mark_read=<?= $row['id'] ?>" class="btn-read">Mark as Read</a>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="panel empty-state">
                        <i class="fa-solid fa-bell-slash" style="font-size: 3rem; margin-bottom: 20px;"></i>
                        <p>No notifications found. You're all caught up!</p>
                    </div>
                <?php endif; ?>
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