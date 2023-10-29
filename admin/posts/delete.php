<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blogdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

try {
    // Validate and sanitize the input
    if (isset($_GET['title']) && !empty($_GET['title'])) {
        $dd = $_GET['title'];
        // You can add further validation if needed (e.g., check if the username exists in the database)
    } else {
        throw new Exception("Invalid or missing 'title' parameter.");
    }

    $stmt = $conn->prepare("DELETE FROM post_tbl WHERE title= ?");
    $stmt->bind_param("s", $dd); 

    if ($stmt->execute()) {
        // Data deleted successfully, now redirect to show.php to display the updated user data
        header("Location: index.php");
        exit; // Ensure the script terminates after the redirect
    } else {
        throw new Exception("Error deleting data: " . $stmt->error);
    }

    $stmt->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

$conn->close();
?>