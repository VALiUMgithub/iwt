<?php
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

$sql = "SELECT * FROM contacts";
$result = mysqli_query($conn, $sql);

$contacts = [];

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $contacts[] = [
            "id" => $row["id"],
            "name" => $row["name"],
            "email" => $row["email"],
            "phone" => $row["phone"],
            "address" => $row["address"]
        ];
    }
}

echo json_encode(["contacts" => $contacts]);

// Close the database connection here
$conn->close();
?>
