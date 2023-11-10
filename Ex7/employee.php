<!DOCTYPE html>
<html>
<head>
<title>Admin Data</title>
<style>
body {
  font-family: Arial, sans-serif;
  background-color: #f5f5f5;
  margin: 0;
  padding: 0;
}

table {
  width: 100%;
  border-collapse: collapse;
  background-color: #fff;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  border-radius: 5px;
}

th, td {
  padding: 15px;
  text-align: left;
  border-bottom: 1px solid #ccc;
}

th {
  background-color: #0074d9;
  color: #fff;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.3s;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
  cursor: pointer;
  transition: background-color 0.3s;
}

tr:hover {
  background-color: #e0e0e0;
}
</style>
</head>
<body>
  <?php
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

    // SQL query to select all data from the 'admins' table
    $sql = "SELECT * FROM admins";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      echo "<h1>Admin Data</h1>";
      echo "<table>";
      echo "<tr><th>Name</th><th>Username</th><th>Email</th></tr>";
      while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["username"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "</tr>";
      }
      echo "</table>";
    } else {
      echo "No admin data found.";
    }

    $conn->close();
  ?>
</body>
</html>
