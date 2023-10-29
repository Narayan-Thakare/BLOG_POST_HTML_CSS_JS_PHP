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
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $description = mysqli_real_escape_string($conn, $_POST["description"]);

    // Use prepared statements with parameter binding for security
    $sql = "UPDATE  topic_tbl SET name = ?, description = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssi", $name, $description, $id);

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
