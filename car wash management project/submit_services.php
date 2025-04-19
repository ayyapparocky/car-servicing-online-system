<?php
// Start session to access username
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_name'])) {
    die("User not logged in");
}

// Get user data from session and POST
$user_name = $_SESSION['user_name'];
$car_number = $_POST['car_number'] ?? '';
$mobile_number = $_POST['mobile_number'] ?? '';
$address = $_POST['address'] ?? '';
$selected_services = $_POST['selected_services'] ?? '';
$total_amount = $_POST['total_amount'] ?? '';


// ✅ Database connection
$servername = "localhost";
$username = "root"; // change if needed
$password = "ayyappa522403"; // change if needed
$database = "car"; // make sure this DB exists
$port = 3305;

$conn = new mysqli($servername, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ✅ Insert data into `service_requests` table
$sql = "INSERT INTO service_requests (user_name, car_number, mobile_number, address, services, total_amount)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssd", $user_name, $car_number, $mobile_number, $address, $selected_services, $total_amount);

if ($stmt->execute()) {
    echo "<script>alert('Service request submitted successfully!'); window.location.href = 'home.php';</script>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
