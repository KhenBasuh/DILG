<?php
// login.php - Admin login page
session_start();

// Redirect if already logged in
if (isset($_SESSION['admin_logged_in'])) {
  header('Location: dashboard.php');
  exit();
}

require 'db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Sample static login for demo
  $adminUser = 'admin';
  $adminPass = 'admin123'; // In production, use hashed passwords and a DB

  if ($username === $adminUser && $password === $adminPass) {
    $_SESSION['admin_logged_in'] = true;
    header('Location: dashboard.php');
    exit();
  } else {
    $error = 'Invalid username or password';
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login - DILG ZDS</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="login-container">
    <h1>Admin Login</h1>
    <?php if ($error): ?>
      <p class="error"><?= $error ?></p>
    <?php endif; ?>
    <form method="POST">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
      </div>
      <button type="submit">Login</button>
    </form>
  </div>

  <script>
    // AJAX polling to check for session (optional session heartbeat)
    setInterval(() => {
      fetch('session_check.php')
        .then(response => response.json())
        .then(data => {
          if (!data.logged_in) {
            window.location.href = 'login.php';
          }
        });
    }, 60000); // every 60 seconds
  </script>
</body>
</html>
