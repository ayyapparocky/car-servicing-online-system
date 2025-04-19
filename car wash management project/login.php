<?php
session_start();
error_reporting(E_ALL);

// Show errors only in development environment
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    ini_set('display_errors', 1);
} else {
    ini_set('display_errors', 0);
    // Optionally, log errors to a file
    ini_set('log_errors', 1);
    ini_set('error_log', '/path/to/error.log');
}

$servername = "localhost";
$username = "root";
$password = "ayyappa522403";
$database = "car";
$port = 3305;

// Create connection
$conn = new mysqli($servername, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure form data is received
if (!isset($_POST['email']) || !isset($_POST['password'])) {
    die("Error: Email or Password not provided.");
}

$email = trim($_POST['email']);
$password = trim($_POST['password']);

// Prepare SQL statement to retrieve stored password hash
$sql = "SELECT name, password FROM registration WHERE email = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error in SQL preparation: " . $conn->error);
}

$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

// Check if user exists
if ($stmt->num_rows > 0) {
    $stmt->bind_result($name, $stored_password_hash);
    $stmt->fetch();

    // Verify the password using password_verify
    if (password_verify($password, $stored_password_hash)) {
        $_SESSION['user_name'] = $name;
        echo "success"; // ✅ Sends response to JavaScript
        exit();
    } else {
        echo "Invalid credentials"; // Incorrect password
        exit();
    }
} else {
    echo "User not found"; // No user with the provided email
    exit();
}

// Close resources
$stmt->close();
$conn->close();
?>
