<?php
session_start();
include 'dbconnect.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];

  // Andaa statement bila password
  $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Verify password
    if (password_verify($password, $user['password'])) {
      // Login success - set session
      $_SESSION["user_id"] = $user["id"];
      $_SESSION["username"] = $user["username"];
      $_SESSION["fullname"] = $user["fullname"];
      $_SESSION["role"] = $user["role"]; // Assuming 'role' column exists in DB

      header("Location: index.php"); // Redirect to dashboard
      exit();
    } else {
      $error = "Invalid password.";
    }
  } else {
    $error = "User not found.";
  }

  $stmt->close();
  $conn->close();
}

?>


<!DOCTYPE html>
<html>
<?php include 'head.php'; // Include your head section with CSS links ?>
<body>
  <div class="form-container">
    <h1 class="form-title">User Login</h1>
    <form method="POST" action="login.php">

      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" class="form-control" required>
      </div>

      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" class="form-control" required>
      </div>

      <!-- <div class="form-group">
        <label>Role:</label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="role" id="admin" value="Admin" required>
          <label class="form-check-label" for="admin">Admin</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="role" id="nurse" value="Nurse">
          <label class="form-check-label" for="nurse">Nurse</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="role" id="socialWorker" value="Doctor">
          <label class="form-check-label" for="socialWorker">Social Worker</label>
        </div>
      </div> -->

      <button type="submit" class="btn btn-primary">Login</button>

      <?php if (!empty($error)) echo "<div class='error mt-3 text-danger'>$error</div>"; ?>
    </form>
  </div>
</body>

</html>
