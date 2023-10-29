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
    $title = mysqli_real_escape_string($conn, $_POST["title"]);
    $body = mysqli_real_escape_string($conn, $_POST["body"]);
    $topic = mysqli_real_escape_string($conn, $_POST["topic"]);

    // Check if a new image was uploaded
    if ($_FILES["image"]["error"] === UPLOAD_ERR_OK) {
        // Process the uploaded image
        $image = $_FILES["image"]["name"];
        $image_tmp = $_FILES["image"]["tmp_name"];

        // Move the uploaded image to a suitable location (e.g., a folder on your server)
        $image_destination = "images/" . $image;

        if (move_uploaded_file($image_tmp, $image_destination)) {
            // Image uploaded successfully
            // Update the database with the new image name
            $sql = "UPDATE post_tbl SET title = ?, body = ?, image = ?, topic = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $title, $body, $image, $topic, $id);

            if ($stmt->execute()) {
            //echo "Data updated successfully.";
            require 'index.php'; 

            } else {
                echo "Error updating data: " . $stmt->error;
            }
        } else {
            echo "Error uploading the image.";
        }
    } else {
        // No new image was uploaded, update the database without changing the image
        $sql = "UPDATE post_tbl SET title = ?, body = ?, topic = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $title, $body, $topic, $id);

        if ($stmt->execute()) {
           // echo "Data updated successfully.";
           require 'index.php'; 

        } else {
            echo "Error updating data: " . $stmt->error;
        }
    }
}

