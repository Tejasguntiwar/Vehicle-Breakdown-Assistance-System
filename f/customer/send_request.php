<?php

session_start();

// // Database configuration
// $servername = "localhost";
// $username = "root";
// $dbname = "vehicle_bk";

// Create connection
$conn = mysqli_connect("localhost", "root", "Tejas12345", "vehicle_bk");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $contact_no = $_POST["contact_no"];
    $email = $_POST["email"];
    $vehicleName = $_POST["vehicleName"];
    $vehicleModel = $_POST["vehicleModel"];
    $problemDescription = $_POST["problemDescription"];
    $assistanceType = $_POST["assistanceType"];

    $uLat = $_COOKIE['userLatitude'];
    $uLng = $_COOKIE['userLongitude'];
    $mLat = $_COOKIE['mechLatitude'];
    $mLng = $_COOKIE['mechLongitude'];

    // Sanitize inputs to prevent SQL injection
    $name = $conn->real_escape_string($name);
    $contact_no = $conn->real_escape_string($contact_no);
    $email = $conn->real_escape_string($email);
    $vehicleName = $conn->real_escape_string($vehicleName);
    $vehicleModel = $conn->real_escape_string($vehicleModel);
    $problemDescription = $conn->real_escape_string($problemDescription);
    $assistanceType = $conn->real_escape_string($assistanceType);

    // Get customer ID from session variable
    $cust_id = $_SESSION['cust_id'];

    // Insert data into the database
    $sql = "INSERT INTO customer_detail (cust_id, mech_id, name, mobile_no, email, vehicle_name, vehicle_model, prob_des, type_ass, lat, lon, mlat, mlon, is_accepted) VALUES ($cust_id, " . $_SESSION['mech_id'] . ", '$name', '$contact_no', '$email', '$vehicleName', '$vehicleModel', '$problemDescription', '$assistanceType', $uLat, $uLng, $mLat, $mLng, false)";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Request submitted successfully.');
                window.location.href = 'cust_dashboard.html';
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();

?>
