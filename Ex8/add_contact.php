<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];

    // Database connection details
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "contact_manager";

// Create a connection to the database
$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

    $sql = "INSERT INTO contacts (name, email, phone, address) VALUES ('$name', '$email', '$phone', '$address')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false]);
    }

    // Close the database connection here
    $conn->close();
}
?>
