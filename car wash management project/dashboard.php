<?php
session_start();
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "ayyappa522403";
$database = "car";
$port = 3305;

$conn = new mysqli($servername, $username, $password, $database, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all service records ordered by car_number to group same car number together
$sql = "SELECT user_name, car_number, mobile_number, address, services, total_amount, status FROM service_requests ORDER BY car_number ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background: url('my.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        table, th, td {
            border: 1px solid #666;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        td {
            color: #ffffff;
        }
        th {
            background-color: rgb(36, 161, 234);
            color: white;
        }
        tr:nth-child(even) {
            background-color: rgb(72, 207, 112);
        }
        form {
            display: inline;
        }
        button {
            padding: 5px 10px;
        }
        .logout {
            float: right;
            margin-top: -50px;
            background-color: #ff4d4d;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 30px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .logout:hover {
            background-color: rgb(193, 45, 201);
        }
        .icon-button {
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h2>Welcome, <?php echo $_SESSION['user_name'] ?? 'Admin'; ?> 😄</h2>
<a class="logout" href="admin.html">Logout</a>

<table>
    <thead>
        <tr>
            <th>User Name</th>
            <th>Car Number</th>
            <th>Mobile Number</th>
            <th>Address</th>
            <th>Services</th>
            <th>Total Amount</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $userName = htmlspecialchars($row['user_name'] ?? '');
                $carNumber = htmlspecialchars($row['car_number'] ?? '');
                $mobileNumber = $row['mobile_number'] ?? ''; // display original mobile number
                $address = htmlspecialchars($row['address'] ?? '');
                $services = htmlspecialchars($row['services'] ?? '');
                $totalAmount = htmlspecialchars($row['total_amount'] ?? '');
                $status = htmlspecialchars($row['status'] ?? '');

                $statusText = ($status === 'completed') ? '✅ Completed' : '';
                $buttonText = ($status === 'completed') ? 'Undo' : 'Complete ✅';
                $buttonColor = ($status === 'completed') ? "background-color:orange;color:white;" : "";

                echo "<tr>";
                echo "<td>$userName</td>";
                echo "<td>$carNumber</td>";
                echo "<td>" . $row['mobile_number'] . "</td>";

                echo "<td>$address</td>";
                echo "<td>$services</td>";
                echo "<td>₹$totalAmount</td>";
                echo "<td>$statusText</td>";
                echo "<td>
                    <form method='POST' action='complete.php'>
                        <input type='hidden' name='car_number' value='$carNumber'>
                        <input type='hidden' name='current_status' value='$status'>
                        <button type='submit' style='$buttonColor'>$buttonText</button>
                    </form>
                    <form method='POST' action='delete.php' onsubmit=\"return confirm('Are you sure you want to delete this record?');\">
                        <input type='hidden' name='car_number' value='$carNumber'>
                        <button type='submit' class='icon-button' title='Delete'><i class='fas fa-trash' style='color:red;'></i></button>
                    </form>
                </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>Today No Services Booked</td></tr>";
        }
        ?>
    </tbody>
</table>

</body>
</html>

<?php $conn->close(); ?>