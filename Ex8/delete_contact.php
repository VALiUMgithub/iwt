<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];

    // Establish a database connection here
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

    // Perform the DELETE operation
    $sql = "DELETE FROM contacts WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false]);
    }

    // Close the database connection here
    $conn->close();
}
?>
