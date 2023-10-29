<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blogdb";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve and sanitize inputs to prevent SQL injection
    $id = $_POST["id"]; // Assuming you have an "id" field in your form
    $inputUsername = mysqli_real_escape_string($conn, $_POST["username"]);
    $role = mysqli_real_escape_string($conn, $_POST["role"]);

    // Use prepared statements with parameter binding for security
    $sql = "UPDATE user_tbl SET username = ?, role = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssi", $inputUsername, $role, $id);

        // Execute the SQL query
        if ($stmt->execute()) {
           // echo "Data updated successfully.";
            $stmt->close();
            require 'index.php'; 
        } else {
            echo "Error updating data: " . $stmt->error;
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}
?>
