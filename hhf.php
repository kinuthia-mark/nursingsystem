<?php
// dashboard.php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}

$fullname = $_SESSION["fullname"];
$role = $_SESSION["role"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo $role; ?> Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f8ff;
      padding: 30px;
    }
    .container {
      max-width: 700px;
      margin: auto;
      background: #fff;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 0 12px rgba(0,0,0,0.1);
      text-align: center;
    }
    h2 {
      color: #007bff;
    }
    p {
      font-size: 18px;
    }
    a {
      display: inline-block;
      margin-top: 20px;
      text-decoration: none;
      color: white;
      background-color: #dc3545;
      padding: 10px 20px;
      border-radius: 5px;
    }
    a:hover {
      background-color: #c82333;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Welcome, <?php echo htmlspecialchars($fullname); ?>!</h2>
    <p>You are logged in as a <strong><?php echo $role; ?></strong>.</p>

    <?php if ($role === 'Admin'): ?>
      <p>Here you can manage users, view reports, and configure system settings.</p>
    <?php elseif ($role === 'Nurse'): ?>
      <p>Access patient medical records and submit medical history reports.</p>
    <?php elseif ($role === 'Doctor'): ?>
      <p>Review patient progress, referrals, and medical evaluations.</p>
    <?php else: ?>
      <p>Role not recognized. Please contact the administrator.</p>
    <?php endif; ?>

    <a href="logout.php">Logout</a>
  </div>
</body>
</html>
