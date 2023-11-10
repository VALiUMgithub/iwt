<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];

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

    $sql = "SELECT name, email, phone, address FROM contacts WHERE id = $id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $contact = [
            "name" => $row["name"],
            "email" => $row["email"],
            "phone" => $row["phone"],
            "address" => $row["address"],
        ];

        echo json_encode(["success" => true, "contact" => $contact]);
    } else {
        echo json_encode(["success" => false]);
    }

    // Close the database connection here
    $conn->close();
}
?>
