<?php
// dashboard.php - Admin Dashboard (after login)
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header('Location: login.php');
  exit();
}

require 'db.php'; // Your database connection file

// Fetch today's visitor count
$today = date('Y-m-d');
$todayCount = $conn->query("SELECT COUNT(*) AS count FROM visitors WHERE DATE(created_at) = '$today'")->fetch_assoc();

// Fetch latest visitor
$latestVisitor = $conn->query("SELECT * FROM visitors ORDER BY created_at DESC LIMIT 1")->fetch_assoc();

// Fetch count for daily, weekly, and monthly visitors
$dayCount = $conn->query("SELECT COUNT(*) AS count FROM visitors WHERE DATE(created_at) = CURDATE()")->fetch_assoc();
$weekCount = $conn->query("SELECT COUNT(*) AS count FROM visitors WHERE YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)")->fetch_assoc();
$monthCount = $conn->query("SELECT COUNT(*) AS count FROM visitors WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())")->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - DILG ZDS</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <div class="dashboard-container">
    <h1>Welcome, Admin</h1>
    <h2>Visitor Summary</h2>

    <div class="stats">
      <div class="stat-box">
        <h3>Today</h3>
        <p><?php echo $dayCount['count']; ?> Visitors</p>
      </div>
      <div class="stat-box">
        <h3>This Week</h3>
        <p><?php echo $weekCount['count']; ?> Visitors</p>
      </div>
      <div class="stat-box">
        <h3>This Month</h3>
        <p><?php echo $monthCount['count']; ?> Visitors</p>
      </div>
    </div>

    <h2>Latest Visitor</h2>
    <div class="visitor-info">
      <?php if ($latestVisitor): ?>
        <p><strong>Name:</strong> <?php echo $latestVisitor['fullName']; ?></p>
        <p><strong>Date & Time:</strong> <?php echo $latestVisitor['created_at']; ?></p>
        <p><strong>Agency/Office:</strong> <?php echo $latestVisitor['agency']; ?></p>
        <p><strong>Purpose:</strong> <?php echo $latestVisitor['purpose']; ?></p>
      <?php else: ?>
        <p>No visitors recorded yet today.</p>
      <?php endif; ?>
    </div>

    <h2>Visitor Chart (Monthly)</h2>
    <canvas id="visitorChart"></canvas>
  </div>

  <script>
    // Chart.js can be updated to pull dynamic data using AJAX for real-time updates
    const ctx = document.getElementById('visitorChart').getContext('2d');
    const visitorChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Today', 'This Week', 'This Month'],
        datasets: [{
          label: 'Visitors',
          data: [<?php echo $dayCount['count']; ?>, <?php echo $weekCount['count']; ?>, <?php echo $monthCount['count']; ?>],
          backgroundColor: ['#4CAF50', '#2196F3', '#FF9800']
        }]
      }
    });
  </script>
</body>
</html>
