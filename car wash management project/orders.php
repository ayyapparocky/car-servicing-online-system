<?php
// ✅ Start session only if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Redirect to login page if not logged in
if (!isset($_SESSION['user_name'])) {
    header("Location: login.html");
    exit();
}

$user_name = $_SESSION['user_name']; // ✅ Get user's name

// Database connection
$servername = "localhost";
$username = "root";
$password = "ayyappa522403";
$database = "car";
$port = 3305;

$conn = new mysqli($servername, $username, $password, $database, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch orders based on the logged-in user
$sql = "SELECT * FROM service_requests WHERE user_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_name);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Your Orders</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: white;
      text-align: center;
      margin: 0;
      flex-direction: column;
    }
    .orders-table {
      width: 80%;
      margin-top: 20px;
      border-collapse: collapse;
    }
    .orders-table th, .orders-table td {
      padding: 10px;
      border: 1px solid #ddd;
      text-align: left;
    }
    .orders-table th {
      background-color: #4CAF50;
      color: white;
    }
    .logout {
      margin-top: 20px;
      padding: 10px 15px;
      background: red;
      color: white;
      text-decoration: none;
      border-radius: 5px;
    }
    h1 {
      color: #333;
    }
  </style>
</head>
<body>

  <h1>Your Orders, <?php echo htmlspecialchars($user_name); ?>!</h1>

  <?php if ($result->num_rows > 0): ?>
    <table class="orders-table">
      <thead>
        <tr>
          <th>Car Number</th>
          <th>Services</th>
          <th>Total Amount</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo htmlspecialchars($row['car_number']); ?></td>
            <td><?php echo htmlspecialchars($row['services']); ?></td>
            <td>₹<?php echo htmlspecialchars($row['total_amount']); ?></td>
            <td><?php echo htmlspecialchars($row['status']); ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>No orders found  <?php echo htmlspecialchars($user_name); ?>.</p>
  <?php endif; ?>

  <a href="logout.php" class="logout">🚪 Logout</a>

</body>
</html>

<?php
// Close connection
$conn->close();
?>
