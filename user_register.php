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
<?php include 'head.php'; ?>
<body>
  <?php include 'sidenav.php'; ?>
  <div class="form-container">
    <h1 class="form-title">User Registration Form</h1>
    
    <form method="POST">
      <div class="form-group">
        <label for="fullname">Full Name</label>
        <input type="text" id="fullname" name="fullname" class="form-control" required>
      </div>

      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" class="form-control" required>
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" class="form-control" required>
      </div>

      <div class="form-group">
        <label for="phone">Phone Number</label>
        <input type="tel" id="phone" name="phone" class="form-control" required>
      </div>

      <div class="form-group">
        <label for="gender">Gender</label>
        <select id="gender" name="gender" class="form-control" required>
          <option value="">--Select Gender--</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
        </select>
      </div>

      <div class="form-group">
        <label for="role">Role</label>
        <select id="role" name="role" class="form-control" required>
          <option value="">--Select Role--</option>
          <option value="Admin">Admin</option>
          <option value="Nurse">Nurse</option>
          <option value="Social Worker">Social Worker</option>
        </select>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" class="form-control" required>
      </div>

      <div class="form-group">
        <label for="confirmPassword">Confirm Password</label>
        <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" required>
      </div>

      <div class="error text-danger" id="errorMsg" style="margin-top: 10px;"></div>

      <button type="submit" class="btn btn-primary">Register</button>
    </form>
  </div>
</body>

</html>
