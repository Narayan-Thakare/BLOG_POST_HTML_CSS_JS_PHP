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

$sql = "SELECT title, body, image, topic FROM post_tbl"; // Select all columns you want to display

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Section - All Posts</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Candal|Lora" rel="stylesheet">
    <!-- Custom Styling -->
    <link rel="stylesheet" href="../../css/style.css">
    <!-- Admin Styling -->
    <link rel="stylesheet" href="../../css/admin.css">
    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
    <header>
        <div class="logo">
            <h1 class="logo-text"><span>&nbsp; My Blog</span>Website</h1>
        </div>
        <ul class="nav">
            <li>
                <a href="#">
                    <i class="fa fa-user"></i>
                    <span class="username">Narayan</span>
                    <a href="logout.php">
                        <i class="fa fa-sign-out"></i>&nbsp;&nbsp;
                    </a>
                </a>
            </li>
        </ul>
    </header>

    <div class="admin-content">
        <div class="content">
            <h2 class="page-title">All Posts</h2>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='post-card-container'>";
                    echo "<div class='post-card'>";
                    echo "<center><img src='images/" . $row['image'] . "'></center>";
                    echo "</div>";
                    echo "<div class='post-content'>";
                    echo "<h2 class='post-title'>" . $row['title'] . "</h2>";
                    echo "<p class='post-body'>" . $row['body'] . "</p>";
                    echo "<p class='post-topic'>" . $row['topic'] . "</p>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "No posts found.";
            }
            ?>
        </div>
    </div>
</body>
</html>
            