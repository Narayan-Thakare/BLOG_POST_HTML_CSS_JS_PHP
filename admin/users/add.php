<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputUsername = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $passwordConf = $_POST["passwordConf"];
    $role = $_POST["role"];

    $servername = "localhost";
    $dbUsername = "root"; // Use a different variable name for the database username
    $dbPassword = "";
    $dbname = "blogdb";

    // Create connection
    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Use prepared statements to prevent SQL injection
    $sql = "INSERT INTO user_tbl (username, email, password, passwordConf, role) VALUES (?,?,?,?,?)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind the parameters
        $stmt->bind_param("sssss", $inputUsername, $email, $password, $passwordConf, $role);

        // Execute the statement
        if ($stmt->execute()) {
           // echo "New record created successfully";
           require 'index.php'; 
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }    
}
?>
