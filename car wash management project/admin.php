<?php
session_start();
error_reporting(E_ALL);

// Show errors only in development
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    ini_set('display_errors', 1);
} else {
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', '/path/to/error.log');
}

// DB credentials
$servername = "localhost";
$username = "root";
$password = "ayyappa522403";
$database = "car";
$port = 3305;

// DB connection
$conn = new mysqli($servername, $username, $password, $database, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$email = trim($_POST['email']);
$password = trim($_POST['password']);

// Prepare SQL
$sql = "SELECT name FROM admin WHERE email = ? AND password = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error preparing SQL: " . $conn->error);
}

$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$stmt->store_result();

// Check login
if ($stmt->num_rows === 1) {
    $stmt->bind_result($name);
    $stmt->fetch();
    
    $_SESSION['user_name'] = $name;
    $_SESSION['user_email'] = $email;
    
    header("Location: dashboard.php");
    exit();
} else {
    echo "Invalid email or password";
    exit();
}

// Cleanup
$stmt->close();
$conn->close();
?>
