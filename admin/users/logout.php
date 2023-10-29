<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_GET["logout"])) {
        setcookie("name", "", time() - 3600, "/"); // Expire the cookie to remove it
        echo "You are successfully logged out!";
    } else {
        // Handle other POST request logic here
        // Include("index.php"); should be placed outside this condition
    }
}
?>
