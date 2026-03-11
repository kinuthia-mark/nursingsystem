<?php
include 'session.php'; 
include 'dbconnect.php'; 

error_reporting(E_ALL);
ini_set('display_errors', 1);

$message = "";
$messageType = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST["fullname"]);
    $username = trim($_POST["username"]);
    $email    = trim($_POST["email"]);
    $phone    = trim($_POST["phone"]);
    $gender   = $_POST["gender"];
    $role     = $_POST["role"];
    $password = $_POST["password"];
    $confirm  = $_POST["confirmPassword"];

    if ($password !== $confirm) {
        $message = "Passwords do not match!";
        $messageType = "danger";
    } else {
        $check_stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $check_stmt->bind_param("ss", $username, $email);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            $message = "Username or Email already exists.";
            $messageType = "danger";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (fullname, username, email, phone, gender, role, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $fullname, $username, $email, $phone, $gender, $role, $hashedPassword);

            if ($stmt->execute()) {
                header("Location: user_register.php?success=1");
                exit();
            } else {
                $message = "Database Error: " . $stmt->error;
                $messageType = "danger";
            }
            $stmt->close();
        }
        $check_stmt->close();
    }
}

if (isset($_GET['success'])) {
    $message = "Staff member registered successfully!";
    $messageType = "success";
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'; ?>
<style>
    /* CRITICAL FIX: Ensures inputs fill the box and look professional */
    .registration-grid {
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
        transition: border-color 0.2s;
    }
    .custom-input:focus {
        border-color: #3b82f6;
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    @media (max-width: 768px) {
        .registration-grid { grid-template-columns: 1fr; }
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
            <section class="content-header" style="margin-bottom: 2rem;">
                <h1 style="font-size: 1.75rem; color: #0f172a;">Staff Management</h1>
                <p style="color: #64748b;">Create and manage system credentials for personnel.</p>
            </section>

            <?php if ($message): ?>
                <div class="alert alert-<?= $messageType; ?> shadow-sm mb-4" style="padding: 1rem; border-radius: 12px; background: <?= $messageType == 'success' ? '#f0fdf4' : '#fef2f2' ?>; border: 1px solid <?= $messageType == 'success' ? '#bbf7d0' : '#fecaca' ?>; color: <?= $messageType == 'success' ? '#166534' : '#991b1b' ?>;">
                    <i class="fa-solid <?= $messageType == 'success' ? 'fa-circle-check' : 'fa-triangle-exclamation' ?> me-2"></i>
                    <?= $message; ?>
                </div>
            <?php endif; ?>

            <div class="data-layout">
                <div class="panel" style="width: 100%; max-width: 1000px; background: #fff; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                    <div class="panel-header" style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0;">
                        <h3 style="margin:0; font-size: 1.1rem; font-weight: 700; color: #1e293b;"><i class="fa-solid fa-user-plus me-2" style="color: #3b82f6;"></i>Registration Form</h3>
                    </div>
                    
                    <div style="padding: 2.5rem;">
                        <form method="POST">
                            <div class="registration-grid">
                                <div>
                                    <div class="form-group" style="margin-bottom: 1.5rem;">
                                        <label>Full Name</label>
                                        <input type="text" name="fullname" class="custom-input" placeholder="e.g. Dr. Jane Smith" required>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 1.5rem;">
                                        <label>Username</label>
                                        <input type="text" name="username" class="custom-input" placeholder="jsmith_nurse" required>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 1.5rem;">
                                        <label>Email Address</label>
                                        <input type="email" name="email" class="custom-input" placeholder="jane@clinic.com" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <input type="tel" name="phone" class="custom-input" placeholder="+254..." required>
                                    </div>
                                </div>

                                <div>
                                    <div class="form-group" style="margin-bottom: 1.5rem;">
                                        <label>Gender</label>
                                        <select name="gender" class="custom-input" required>
                                            <option value="">--Select--</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 1.5rem;">
                                        <label>System Role</label>
                                        <select name="role" class="custom-input" required>
                                            <option value="">--Select Role--</option>
                                            <?php
                                            $role_query = $conn->query("SELECT userlevelname FROM user_level ORDER BY userlevelname ASC");
                                            while($row = $role_query->fetch_assoc()): ?>
                                                <option value="<?= $row['userlevelname'] ?>"><?= $row['userlevelname'] ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 1.5rem;">
                                        <label>Password</label>
                                        <input type="password" name="password" class="custom-input" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" name="confirmPassword" class="custom-input" required>
                                    </div>
                                </div>
                            </div>

                            <div style="margin-top: 3rem; display: flex; justify-content: flex-end; gap: 1rem; border-top: 1px solid #e2e8f0; padding-top: 1.5rem;">
                                <button type="reset" class="btn-light" style="padding: 12px 24px; border-radius: 8px; border: 1px solid #cbd5e1; background: #f8fafc; font-weight: 600; cursor: pointer;">
                                    <i class="fa-solid fa-rotate-left me-1"></i> Clear Fields
                                </button>
                                <button type="submit" class="btn-primary" style="padding: 12px 40px; border-radius: 8px; border: none; background: #2563eb; color: white; font-weight: 700; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);">
                                    <i class="fa-solid fa-user-plus me-1"></i> Register Staff Member
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