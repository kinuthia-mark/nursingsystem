<?php
include 'dbconnect.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $fullname = $_POST["fullname"];
  $username = $_POST["username"];
  $email = $_POST["email"];
  $phone = $_POST["phone"];
  $gender = $_POST["gender"];
  $role = $_POST["role"];
  $password = $_POST["password"];
  $confirmPassword = $_POST["confirmPassword"];

  // Check if passwords match
  if ($password !== $confirmPassword) {
    echo "<script>alert('Passwords do not match!');</script>";
  } else {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (fullname, username, email, phone, gender, role, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $fullname, $username, $email, $phone, $gender, $role, $hashedPassword);

    if ($stmt->execute()) {
      echo "<script>alert('Registration successful!');</script>";
    } else {
      echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Registration Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      padding: 20px;
    }
    .form-container {
      max-width: 500px;
      background: #fff;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      margin: auto;
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    label {
      display: block;
      margin-top: 10px;
      font-weight: bold;
    }
    input, select {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .btn {
      background: #28a745;
      color: #fff;
      padding: 10px;
      margin-top: 15px;
      border: none;
      cursor: pointer;
      width: 100%;
      border-radius: 5px;
      font-size: 16px;
    }
    .btn:hover {
      background: #218838;
    }
    .error {
      color: red;
      font-size: 14px;
      margin-top: 5px;
    }
  </style>
</head>
<body>

<div class="form-container">
  <h2>User Registration Form</h2>
  <form method="POST">
    <label for="fullname">Full Name</label>
    <input type="text" id="fullname" name="fullname" required>

    <label for="username">Username</label>
    <input type="text" id="username" name="username" required>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" required>

    <label for="phone">Phone Number</label>
    <input type="tel" id="phone" name="phone" required>

    <label for="gender">Gender</label>
    <select id="gender" name="gender" required>
      <option value="">--Select Gender--</option>
      <option value="Male">Male</option>
      <option value="Female">Female</option>
    </select>

    <label for="role">Role</label>
    <select id="role" name="role" required>
      <option value="">--Select Role--</option>
      <option value="Admin">Admin</option>
      <option value="Nurse">Nurse</option>
      <option value="Social Worker">Social Worker</option>
    </select>

    <label for="password">Password</label>
    <input type="password" id="password" name="password" required>

    <label for="confirmPassword">Confirm Password</label>
    <input type="password" id="confirmPassword" name="confirmPassword" required>
    
    <div class="error" id="errorMsg"></div>

    <button type="submit" class="btn">Register</button>
  </form>
</div>

</body>
</html>
