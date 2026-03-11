<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'session.php';
include 'dbconnect.php';

$alert_script = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $levelName = $_POST["levelName"];
  $stmt = $conn->prepare("INSERT INTO user_level(userlevelname) VALUES (?)");
  $stmt->bind_param("s", $levelName);

  if ($stmt->execute()) {
    $alert_script = "
        <script>
            Swal.fire({
                title: 'Success!',
                text: 'New user level created successfully',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>";
  } else {
    $alert_script = "<script>Swal.fire('Error', '" . addslashes($stmt->error) . "', 'error');</script>";
  }
  $stmt->close();
}
?>
<!DOCTYPE html> 
<html lang="en">
<?php include 'head.php'; ?>
<style>
    /* Ensures the panels sit side-by-side or stack correctly */
    .data-layout {
        display: flex;
        gap: 1.5rem;
        align-items: flex-start;
        flex-wrap: wrap;
    }
    .main-form-panel {
        flex: 1;
        min-width: 300px;
        background: #fff;
        border-radius: 12px;
        border: 1px solid var(--border);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    .side-tip-panel {
        flex: 0 0 300px;
        background: #f8fafc;
        border: 2px dashed #e2e8f0;
        border-radius: 12px;
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
                <div class="user-info" style="margin-left: 20px; font-weight: 600; color: #64748b;">
                    <i class="fa-solid fa-user-shield"></i> Admin
                </div>
            </div>
        </header>

        <div class="scroll-area">
            <section class="content-header" style="margin-bottom: 2rem;">
                <h1 style="font-size: 1.75rem; color: #0f172a;">User Access Configuration</h1>
                <p style="color: #64748b;">Manage system roles and permission levels.</p>
            </section>

            <div class="data-layout">
                <div class="main-form-panel">
                    <div class="panel-header" style="padding: 1.25rem; border-bottom: 1px solid #e2e8f0;">
                        <h3 style="margin:0; font-size: 1.1rem; font-weight: 700;">Create New User Level</h3>
                    </div>
                    
                    <div style="padding: 2rem;">
                        <form id="userLevelForm" method="post">
                            <div class="mb-4">
                                <label for="levelName" class="form-label" style="font-weight: 600; color: #475569; display: block; margin-bottom: 0.5rem;">Level Name</label>
                                <input type="text" id="levelName" name="levelName" class="form-control form-control-lg" placeholder="e.g. Senior Nurse, Pharmacist" required style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px;">
                                <small style="display: block; margin-top: 0.5rem; color: #94a3b8;">This name will define access rights for assigned users.</small>
                            </div>

                            <button type="submit" class="btn-primary" style="width: 100%; border: none; padding: 14px; border-radius: 8px; font-weight: 700; background: var(--primary); color: #fff; cursor: pointer; transition: opacity 0.2s;">
                                <i class="fa-solid fa-save me-2"></i> Save User Level
                            </button>
                        </form>
                    </div>
                </div>

                <div class="side-tip-panel">
                    <div style="padding: 1.5rem;">
                        <h5 style="font-size: 0.9rem; font-weight: 700; color: #1e293b; margin-top: 0; margin-bottom: 0.75rem;">
                            <i class="fa-solid fa-lightbulb" style="color: #eab308;"></i> Role Tip
                        </h5>
                        <p style="font-size: 0.85rem; color: #64748b; line-height: 1.5; margin: 0;">
                            Once a level is created, you can assign it to staff members via the User Management screen.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function runClock() {
        const el = document.getElementById('digital-clock');
        if (el) el.textContent = new Date().toLocaleTimeString('en-GB');
    }
    setInterval(runClock, 1000);
    runClock();

    <?php if ($alert_script) echo $alert_script; ?>
</script>

</body>
</html>