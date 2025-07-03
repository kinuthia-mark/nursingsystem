<?php
session_start();
include 'dbconnect.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];
  $role = $_POST["role"];

  $stmt = $conn->prepare("SELECT id, fullname, password FROM users WHERE username = ? AND role = ?");
  $stmt->bind_param("ss", $username, $role);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
      $_SESSION["user_id"] = $user["id"];
      $_SESSION["fullname"] = $user["fullname"];
      $_SESSION["role"] = $role;
      header("Location: dashboard.php"); // Replace with your dashboard
      exit();
    } else {
      $error = "Invalid password.";
    }
  } else {
    $error = "User not found or role mismatch.";
  }

  $stmt->close();
  $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>User Login</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #eef2f7;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .login-container {
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 16px rgba(1, 247, 255, 0.5);
      width: 400px;
    }

    h2 {
      text-align: center;
      color: #007bff;
      margin-bottom: 20px;
    }

    label {
      font-weight: bold;
      margin-top: 10px;
      display: block;
    }

    input[type="text"],
    input[type="password"],
    input[type="radio"] {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    .radio-group {
      display: flex;
      justify-content: space-between;
      margin-top: 10px;
    }

    .radio-group label {
      font-weight: normal;
      display: inline-block;
      width: auto;
    }

    button {
      width: 100%;
      margin-top: 20px;
      padding: 10px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 18px;
      cursor: pointer;
    }

    button:hover {
      background-color: #0056b3;
    }

    .error {
      color: red;
      margin-top: 10px;
      text-align: center;
    }
  </style>
</head>
<body>

  <div class="login-container">
    <h2>User Login</h2>
    <form method="POST" action="login.php">
      <label for="username">Username:</label>
      <input type="text" name="username" id="username" required>

      <label for="password">Password:</label>
      <input type="password" name="password" id="password" required>

      <label>Role:</label>
      <div class="radio-group">
        <label><input type="radio" name="role" value="Admin" required> Admin</label>
        <label><input type="radio" name="role" value="Nurse"> Nurse</label>
        <label><input type="radio" name="role" value="Doctor"> Social Worker</label>
      </div>

      <button type="submit">Login</button>
      <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>
    </form>
  </div>

</body>
</html>
