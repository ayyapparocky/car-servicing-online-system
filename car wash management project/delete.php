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

if (!empty($car_number)) {
    // Delete record based on car_number
    $sql = "DELETE FROM service_requests WHERE car_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $car_number);  // Use "s" for string since car_number is a string
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header("Location: dashboard.php");
exit();
