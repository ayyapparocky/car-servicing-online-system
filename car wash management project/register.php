<?php
$servername = "localhost";
$username = "root";
$password = "ayyappa522403";
$database = "car";
$port = 3305;

header('Content-Type: application/json');

$conn = new mysqli($servername, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

// Check required fields
if (!isset($_POST['name'], $_POST['email'], $_POST['mobile'], $_POST['password'])) {
    echo json_encode(['success' => false, 'error' => 'All fields are required.']);
    exit;
}

// Sanitize input
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$mobile = trim($_POST['mobile']);
$password = trim($_POST['password']);

// Validate email and mobile
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'error' => 'Invalid email format.']);
    exit;
}

if (!preg_match("/^[0-9]{10}$/", $mobile)) {
    echo json_encode(['success' => false, 'error' => 'Invalid mobile number.']);
    exit;
}

// Check for existing email
$checkStmt = $conn->prepare("SELECT email FROM registration WHERE email = ?");
$checkStmt->bind_param("s", $email);
$checkStmt->execute();
$checkStmt->store_result();

if ($checkStmt->num_rows > 0) {
    echo json_encode(['success' => false, 'error' => 'Email already exists']);
    $checkStmt->close();
    $conn->close();
    exit;
}
$checkStmt->close();

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert user
$stmt = $conn->prepare("INSERT INTO registration (name, email, mobile, password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $mobile, $hashed_password);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Registration failed: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>