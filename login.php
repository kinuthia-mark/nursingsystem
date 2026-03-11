<?php
session_start();
require_once 'dbconnect.php';

$error = '';
$success_msg = '';

// Check if redirected from logout.php
if (isset($_GET['status']) && $_GET['status'] == 'logged_out') {
    $success_msg = "You have been securely logged out.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["fullname"] = $user["fullname"];
            $_SESSION["role"] = $user["role"];

            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid credentials. Please try again.";
        }
    } else {
        $error = "Account not found in the registry.";
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'head.php'; ?>
    <style>
        :root {
            --primary: #2563eb;
            --bg-soft: #f8fafc;
            --text-main: #1e293b;
        }

        body {
            background: linear-gradient(135deg, #f0f7ff 0%, #ffffff 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            font-family: 'Inter', sans-serif;
        }

        .login-card {
            background: #ffffff;
            width: 100%;
            max-width: 400px;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border: 1px solid #e2e8f0;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand-icon {
            width: 60px;
            height: 60px;
            background: #dbeafe;
            color: var(--primary);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin: 0 auto 15px;
        }

        .login-header h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-main);
            margin: 0;
        }

        .login-header p {
            color: #64748b;
            font-size: 0.9rem;
            margin-top: 5px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748b;
            margin-bottom: 8px;
            letter-spacing: 0.025em;
        }

        .main-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.2s;
            box-sizing: border-box;
        }

        .main-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .btn-login {
            width: 100%;
            background: var(--primary);
            color: white;
            padding: 14px;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
            margin-top: 10px;
        }

        .btn-login:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }

        .error-box {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            text-align: center;
            margin-bottom: 20px;
            border: 1px solid #fecaca;
        }

        .success-box {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            text-align: center;
            margin-bottom: 20px;
            border: 1px solid #bbf7d0;
        }

        .login-footer {
            text-align: center;
            margin-top: 25px;
            font-size: 0.8rem;
            color: #94a3b8;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="login-header">
        <div class="brand-icon">
            <i class="fa-solid fa-shield-heart"></i>
        </div>
        <h1>Clinical Portal</h1>
        <p>Authorized Personnel Only</p>
    </div>

    <?php if (!empty($success_msg)): ?>
        <div class="success-box">
            <i class="fa-solid fa-circle-check"></i> <?= $success_msg ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="error-box">
            <i class="fa-solid fa-circle-exclamation"></i> <?= $error ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <div class="form-group">
            <label class="form-label" for="username">Username</label>
            <input type="text" name="username" id="username" class="main-input" placeholder="Enter your username" required autofocus>
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input type="password" name="password" id="password" class="main-input" placeholder="••••••••" required>
        </div>

        <button type="submit" class="btn-login">
            Secure Sign In
        </button>
    </form>

    <div class="login-footer">
        &copy; <?= date('Y') ?> Health Management System<br>
    </div>
</div>

</body>
</html>