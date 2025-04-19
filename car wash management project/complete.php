<?php
$servername = "localhost";
$username = "root";
$password = "ayyappa522403";
$database = "car";
$port = 3305;

$conn = new mysqli($servername, $username, $password, $database, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$car_number = $_POST['car_number'] ?? '';
$current_status = $_POST['current_status'] ?? '';

if (!empty($car_number)) {
    if ($current_status === 'completed') {
        // Set status to NULL (clear it)
        $stmt = $conn->prepare("UPDATE service_requests SET status = NULL WHERE car_number = ?");
        $stmt->bind_param("s", $car_number);
    } else {
        // Set status to 'completed'
        $new_status = 'completed';
        $stmt = $conn->prepare("UPDATE service_requests SET status = ? WHERE car_number = ?");
        $stmt->bind_param("ss", $new_status, $car_number);
    }

    $stmt->execute();
    $stmt->close();
}

$conn->close();
header("Location: dashboard.php");
exit();
