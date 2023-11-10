<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle registration form submission

    // Database connection details
    $db_host = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_name = "company_db";

    // Retrieve user data from the registration form
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $name = $_POST["name"];
    $email = $_POST["email"];
    $role = $_POST["role"]; // Employee or Admin

    // Create a connection to the database
    $conn = new mysqli($db_host, $db_user, $db_password, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the username is already taken in either admins or employees table
    $check_sql = "SELECT * FROM admins WHERE username = ? UNION SELECT * FROM employees WHERE username = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ss", $username, $username);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo "Username already taken. Please choose a different one.";
    } else {
        // Insert user data into the appropriate table based on the role
        if ($role === 'admin') {
            $insert_sql = "INSERT INTO admins (username, password, name, email, role) VALUES (?, ?, ?, ?, ?)";
        } else {
            $insert_sql = "INSERT INTO employees (username, password, name, email, role) VALUES (?, ?, ?, ?, ?)";
        }

        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("sssss", $username, $password, $name, $email, $role);

        if ($insert_stmt->execute()) {
            header("Location: login.html"); // Redirect to login page after successful registration
        } else {
            echo "Registration failed: " . $insert_stmt->error;
        }

        $insert_stmt->close();
    }

    $check_stmt->close();
    $conn->close();
}
?>
