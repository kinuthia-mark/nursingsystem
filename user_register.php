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
            $message = "Username or Email already exists in the system.";
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
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>N-DBMS | Staff Registration</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="dashboard-container">
        <?php include 'sidenav.php'; ?>

        <main class="main-content">
            <header class="top-bar">
                <div class="page-title-area">
                    <h2 style="font-weight: 700; color: var(--text-main); margin: 0;">User Management</h2>
                    <p style="font-size: 0.8rem; color: var(--text-muted); margin: 0;">System / Add New Staff</p>
                </div>

                <div class="header-right">
                    <div class="live-clock">
                        <i class="fa-regular fa-clock"></i>
                        <span id="digital-clock">00:00:00</span>
                    </div>
                </div>
            </header>

            <div class="scroll-area">
                <div class="content-header">
                    <div class="header-text">
                        <h1>Staff Registration</h1>
                        <p>Create credentials for new medical or administrative personnel.</p>
                    </div>
                </div>

                <div class="form-card" style="background: white; padding: 30px; border-radius: 16px; box-shadow: var(--card-shadow); max-width: 1000px;">
                    
                    <?php if ($message): ?>
                        <div class="alert alert-<?= $messageType; ?>" style="margin-bottom: 25px; padding: 15px; border-radius: 12px; border-left: 5px solid <?= $messageType == 'success' ? '#10b981' : '#ef4444' ?>; background: <?= $messageType == 'success' ? '#ecfdf5' : '#fef2f2' ?>; color: <?= $messageType == 'success' ? '#065f46' : '#991b1b' ?>;">
                            <i class="fa-solid <?= $messageType == 'success' ? 'fa-circle-check' : 'fa-triangle-exclamation' ?>" style="margin-right: 10px;"></i>
                            <?= $message; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px;">
                            
                            <div class="form-column">
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label style="display:block; font-weight:600; margin-bottom:8px; font-size:0.9rem;">Full Name</label>
                                    <input type="text" name="fullname" class="form-control" placeholder="e.g. Dr. Jane Smith" required style="width:100%; padding:12px; border:1px solid #e2e8f0; border-radius:8px;">
                                </div>

                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label style="display:block; font-weight:600; margin-bottom:8px; font-size:0.9rem;">Username</label>
                                    <input type="text" name="username" class="form-control" placeholder="jsmith_nurse" required style="width:100%; padding:12px; border:1px solid #e2e8f0; border-radius:8px;">
                                </div>

                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label style="display:block; font-weight:600; margin-bottom:8px; font-size:0.9rem;">Email Address</label>
                                    <input type="email" name="email" class="form-control" placeholder="jane.smith@nurseflow.com" required style="width:100%; padding:12px; border:1px solid #e2e8f0; border-radius:8px;">
                                </div>

                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label style="display:block; font-weight:600; margin-bottom:8px; font-size:0.9rem;">Phone Number</label>
                                    <input type="tel" name="phone" class="form-control" placeholder="+254..." required style="width:100%; padding:12px; border:1px solid #e2e8f0; border-radius:8px;">
                                </div>
                            </div>

                            <div class="form-column">
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label style="display:block; font-weight:600; margin-bottom:8px; font-size:0.9rem;">Gender Identity</label>
                                    <select name="gender" class="form-control" required style="width:100%; padding:12px; border:1px solid #e2e8f0; border-radius:8px;">
                                        <option value="">--Select Gender--</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>

                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label style="display:block; font-weight:600; margin-bottom:8px; font-size:0.9rem;">System Role</label>
                                    <select name="role" class="form-control" required style="width:100%; padding:12px; border:1px solid #e2e8f0; border-radius:8px;">
                                        <option value="">--Select Role--</option>
                                        <option value="Admin">Administrator</option>
                                        <option value="Nurse">Registered Nurse</option>
                                        <option value="Social Worker">Social Worker</option>
                                    </select>
                                </div>

                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label style="display:block; font-weight:600; margin-bottom:8px; font-size:0.9rem;">Security Password</label>
                                    <input type="password" name="password" class="form-control" required style="width:100%; padding:12px; border:1px solid #e2e8f0; border-radius:8px;">
                                </div>

                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label style="display:block; font-weight:600; margin-bottom:8px; font-size:0.9rem;">Confirm Password</label>
                                    <input type="password" name="confirmPassword" class="form-control" required style="width:100%; padding:12px; border:1px solid #e2e8f0; border-radius:8px;">
                                </div>
                            </div>
                        </div>

                        <div class="form-actions" style="margin-top: 30px; display: flex; gap: 15px; justify-content: flex-end;">
                            <button type="reset" class="btn-secondary" style="padding: 12px 25px; cursor: pointer; border-radius: 8px; border: 1px solid #e2e8f0; background: #f8fafc; font-weight: 600;">
                                <i class="fa-solid fa-rotate-left"></i> Clear Fields
                            </button>
                            <button type="submit" class="btn-primary" style="padding: 12px 30px; cursor: pointer; border-radius: 8px; border: none; background: var(--primary); color: white; font-weight: 600; box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);">
                                <i class="fa-solid fa-user-plus"></i> Register Staff Member
                            </button>
                        </div>
                    </form>
                </div>
            </div> 
        </main>
    </div>

    <script>
        // Keeping your clock script for consistency
        function updateClock() {
            const now = new Date();
            document.getElementById('digital-clock').textContent = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
</body>
</html>