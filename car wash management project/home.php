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
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Home</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background: none;
      background-repeat: no-repeat;
      background-size: 100% 100%;
      text-align: center;
      margin: 0;
      flex-direction: column;
    }
    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(-30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .welcome-slide {
      animation: slideIn 1s ease-out forwards;
    }

    .main-container {
      display: flex;
      justify-content: space-between;
      width: 100%;
      max-width: 1200px;
      gap: 20px;
      padding: 20px;
    }

    .container {
      padding: 20px;
      border-radius: 8px;
      flex: 1;
      min-height: 400px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      background-color: transparent;
    }

    .input-row {
      display: flex;
      gap: 15px;
      margin-bottom: 20px;
      justify-content: center;
    }

    .input-row > div {
      display: flex;
      flex-direction: column;
      flex: 1;
      min-width: 200px;
    }

    .input-row input {
      padding: 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    .error {
      color: red;
      font-size: 14px;
      margin-top: 5px;
      text-align: left;
    }

    .payment-container {
      padding: 10px;
      border-radius: 8px;
      flex: 0.3;
      min-height: auto;
      height: fit-content;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      align-items: center;
      background-color: transparent;
    }

    .payment-container .total-amount,
    .payment-container button {
      margin-bottom: 8px;
      padding:14px 20px;
      font-size:18px;
    }

    h1, h2 {
      color: #333;
    }

    ul {
      list-style: none;
      padding: 0;
    }

    ul li {
      background: rgb(4, 162, 248);
      color: white;
      margin: 5px 0;
      padding: 10px;
      border-radius: 5px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .service {
      color: white;
      text-decoration: none;
      display: inline-block;
    }

    .checkbox-container {
      display: flex;
      align-items: center;
    }

    .checkbox-container input {
      margin-left: 10px;
      transform: scale(1.5);
    }

    .logout {
      margin-top: -15px;
      padding: 10px 15px;
      background: red;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      align-self: center;
    }

    .orders-button {
      padding: 10px 15px;
      background:rgb(230, 17, 195);
      color: white;
      text-decoration: none;
      border-radius: 999px;
      margin-bottom: 20px;
      font-size: 16px;
    }

    input::placeholder {
      color: #000000; /* Pure black */
      opacity: 1;     /* Make sure it's fully visible */
    }

    body::before {
      content: "";
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('home.jpg') no-repeat center center;
      background-size: 100% 100%;
      filter: blur(1px);
      z-index: -1;
    }

    .top-bar {
      width: 100%;
      display: flex;
      justify-content: flex-end;
      padding: 10px 20px 0 20px;
      box-sizing: border-box;
    }

    button[type="submit"]:hover {
      background-color:rgb(202, 227, 12); /* 🧡 Change this to whatever color you like */
      color: white;              /* Optional: change text color */
      cursor: pointer;           /* Makes the pointer appear as a hand */
      transition: background-color 0.3s ease; /* Smooth effect */
      box-shadow: 0 8px 30px 10px rgba(211, 209, 209, 0.93);
    }

    #total-amount {
      color: #FF5722;
      font-weight: bold;
      font-size: 20px;
    }

    .marquee-wrapper {
      width: 100%;
      overflow: hidden;
      white-space: nowrap;
      box-sizing: border-box;
      margin-bottom: 20px;
    }

    .marquee-text {
      display: inline-block;
      padding-left: 100%;
      animation: marquee 15s linear infinite;
      font-size: 28px;
      color: #2bf707;
    }

    @keyframes marquee {
      0%   { transform: translateX(0%); }
      100% { transform: translateX(-100%); }
    }

    h2{
      color: #9f2bed;
    }

    h3{
      color:#FF5722;
    }
  </style>
</head>
<body>

<!-- Orders Button -->
<div class="top-bar">
  <a href="orders.php" class="orders-button">View Orders</a>
</div>

<div class="main-container">
  <div class="container">
  <div class="marquee-wrapper">
    <div class="marquee-text">👋 Welcome, <?php echo htmlspecialchars($user_name); ?>! </div>
  </div>

    <h2>🚗 Our Car Services</h2>

    <form method="post" action="submit_services.php" onsubmit="return prepareSubmission();">
      <div class="input-row">
        <div>
          <input type="text" id="car_number" name="car_number" placeholder="Car Number" required>
          <div class="error" id="car_number_error"></div>
        </div>

        <div>
          <input type="text" id="mobile_number" name="mobile_number" placeholder="10-Digit Mobile Number" required>
          <div class="error" id="mobile_number_error"></div>
        </div>

        <div>
          <input type="text" id="address" name="address" placeholder=" Your Address" required>
          <div class="error" id="address_error"></div>
        </div>
      </div>

      <ul>
        <li>
          <span class="service">🚿 Car Wash & Detailing</span>
          <div class="checkbox-container">
            <input type="checkbox" name="services[]" value="car_wash" onclick="updateTotalAmount()">
          </div>
        </li>
        <li>
          <span class="service">🛢 Oil Change & Maintenance</span>
          <div class="checkbox-container">
            <input type="checkbox" name="services[]" value="oil_change" onclick="updateTotalAmount()">
          </div>
        </li>
        <li>
          <span class="service">🔧 Engine Diagnostics</span>
          <div class="checkbox-container">
            <input type="checkbox" name="services[]" value="engine_diagnostics" onclick="updateTotalAmount()">
          </div>
        </li>
        <li>
          <span class="service">🚘 Tire Check & Replacement</span>
          <div class="checkbox-container">
            <input type="checkbox" name="services[]" value="tire_check" onclick="updateTotalAmount()">
          </div>
        </li>
        <li>
          <span class="service">🛠 Brake Inspection & Repair</span>
          <div class="checkbox-container">
            <input type="checkbox" name="services[]" value="brake_inspection" onclick="updateTotalAmount()">
          </div>
        </li>
      </ul>

      <div class="payment-container">
        <div class="total-amount">
          <h3>Total: <span id="total-amount">₹0.00</span></h3>
        </div>
        <input type="hidden" name="selected_services" id="selected-services">
        <input type="hidden" name="total_amount" id="hidden-total">
        <button type="submit">Submit</button>
      </div>
    </form>
  </div>
</div>
<a href="logout.php" class="logout">🚪 Logout</a>

<script>
  function updateTotalAmount() {
    let total = 0;
    const selectedServices = document.querySelectorAll('input[type="checkbox"]:checked');

    const prices = {
      "car_wash": 1500,
      "oil_change": 500,
      "engine_diagnostics": 600,
      "tire_check": 300,
      "brake_inspection": 200
    };

    let services = [];

    selectedServices.forEach(service => {
      total += prices[service.value] || 0;
      services.push(service.value);
    });

    document.getElementById("total-amount").textContent = `₹${total.toFixed(2)}`;
    document.getElementById("selected-services").value = services.join(',');
    document.getElementById("hidden-total").value = total.toFixed(2);
  }

  function prepareSubmission() {
    let isValid = true;

    const carNumberInput = document.getElementById("car_number");
    const mobileInput = document.getElementById("mobile_number");
    const addressInput = document.getElementById("address");

    const carNumber = carNumberInput.value.trim();
    const mobile = mobileInput.value.trim();
    const address = addressInput.value.trim();

    const carNumberError = document.getElementById("car_number_error");
    const mobileError = document.getElementById("mobile_number_error");
    const addressError = document.getElementById("address_error");

    // Clear errors
    carNumberError.textContent = "";
    mobileError.textContent = "";
    addressError.textContent = "";

    const carPattern = /^[A-Z0-9]{5,}$/;  // Letters must be uppercase and there must be at least 5 characters.
    const mobilePattern = /^\d{10}$/;

    if (!carNumber) {
      carNumberError.textContent = "Car number is required.";
      isValid = false;
    } else if (!carPattern.test(carNumber)) {
      // Check if car number contains only uppercase letters and digits
      if (/[a-z]/.test(carNumber)) {
        carNumberError.textContent = "Car number must contain uppercase letters.";
      } else {
        carNumberError.textContent = "Car number must contain both letters and digits.";
      }
      isValid = false;
    }

    if (!mobile) {
      mobileError.textContent = "Mobile number is required.";
      isValid = false;
    } else if (!mobilePattern.test(mobile)) {
      mobileError.textContent = "Mobile must be exactly 10 digits.";
      isValid = false;
    }

    if (!address) {
      addressError.textContent = "Address is required.";
      isValid = false;
    }

    const services = document.getElementById("selected-services").value;
    if (!services) {
      alert("Please select at least one service.");
      isValid = false;
    }

    return isValid;
  }
</script>

</body>
</html>
