<?php
// Database connection settings
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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure form data is received
    if (!isset($_POST['car_number']) || !isset($_POST['mobile']) || !isset($_POST['address'])) {
        die("Error: All fields are required.");
    }

    // Get and sanitize form data
    $car_number = trim($_POST['car_number']);
    $mobile = trim($_POST['mobile']);
    $address = trim($_POST['address']);

    // Validate inputs
    if (!preg_match("/[A-Za-z]+[0-9]+|[0-9]+[A-Za-z]+/", $car_number)) {
        die("Error: Car number must contain both letters and numbers.");
    }

    if (!preg_match("/^[0-9]{10}$/", $mobile)) {
        die("Error: Invalid mobile number. Please enter a valid 10-digit mobile number.");
    }

    if (empty($address)) {
        die("Error: Address is required.");
    }

    // Prepare and bind statement for inserting the data into the database
    $stmt = $conn->prepare("INSERT INTO services_db (car_number, mobile, address) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $car_number, $mobile, $address); // Bind the variables to the SQL statement

    // Execute the statement for inserting data into the database
    if ($stmt->execute()) {
        // If successful, redirect the user to selectservice.php
        echo "<script>
                alert('Data successfully inserted!');
                window.location.href = 'selectservice.php';
              </script>";
    } else {
        // If there's an error, show the error message
        echo "<script>
                alert('Error inserting data: " . $stmt->error . "');
                window.location.href = 'register.html'; // You can change the URL as needed
              </script>";
    }

    // Close the prepared statement and connection
    $stmt->close();
    $conn->close();
}
?>
