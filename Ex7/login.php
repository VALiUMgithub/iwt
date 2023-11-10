<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection details
    $db_host = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_name = "company_db";

    // Create a connection to the database
    $conn = new mysqli($db_host, $db_user, $db_password, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_POST["username"];
    $password = $_POST["password"];

    // Try to find the user in the 'admins' table
    $sql_admin = "SELECT id, password FROM admins WHERE username = ?";
    $stmt_admin = $conn->prepare($sql_admin);
    $stmt_admin->bind_param("s", $username);
    $stmt_admin->execute();
    $stmt_admin->bind_result($id_admin, $hashedPassword_admin);
    $stmt_admin->fetch();
    $stmt_admin->close();

    // Try to find the user in the 'employees' table
    $sql_employee = "SELECT id, password FROM employees WHERE username = ?";
    $stmt_employee = $conn->prepare($sql_employee);
    $stmt_employee->bind_param("s", $username);
    $stmt_employee->execute();
    $stmt_employee->bind_result($id_employee, $hashedPassword_employee);
    $stmt_employee->fetch();
    $stmt_employee->close();

    if (!empty($id_admin) && password_verify($password, $hashedPassword_admin)) {
        // User is an admin
        session_start();
        $_SESSION['user_id'] = $id_admin;
        header("Location: admin.php"); // Redirect to admin dashboard
    } elseif (!empty($id_employee) && password_verify($password, $hashedPassword_employee)) {
        // User is an employee
        session_start();
        $_SESSION['user_id'] = $id_employee;
        header("Location: employee.php"); // Redirect to employee dashboard
    } else {
        echo "Incorrect username or password.";
    }

    $conn->close();
}


?>
