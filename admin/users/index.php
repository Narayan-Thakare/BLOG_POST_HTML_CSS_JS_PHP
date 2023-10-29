<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
$sql = "SELECT id, username, role FROM user_tbl";

$result = $conn->query($sql);

if (!$result) {
    die("Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Section - Manage Users</title>
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--Google Fonts-->
    <link href="https://fonts.googleapis.com/css?family=Candal|Lora" rel="stylesheet">
    <!--Custom Styling-->
    <link rel="stylesheet" href="../../css/style.css">
    <!--Admin Styling-->
    <link rel="stylesheet" href="../../css/admin.css">
    <!-- JQuery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!--Custom Script-->
    <script src="../../js/script.js"></script>
</head>
<body>
<header>
        <div class="logo">
            <h1 class="logo-text"><span>&nbsp;Blog</span>Website</h1>
        </div>
        <ul class="nav">
            <li>
                <a href="#">
                    <i class="fa fa-user"></i>
                    <span class="username">Amisha</span>
                    <a href="logout.php">
                        <i class="fa fa-sign-out"></i>&nbsp;&nbsp; 
                    </a>
                </a>                
            </li>
        </ul>
  </header>
    

<!-- Admin Page Wrapper-->
<div class="admin-wrapper">
<!-- Left Sidebar-->
<div class="left-sidebar">
<ul>
    <li><a href="../posts/index.php">Manage Posts</a></li>
    <li><a href="index.php">Manage Users</a></li>
    <li><a href="../topics/index.php">Manage Topics</a></li>
</ul>

</div>
<!--//Left Sidebar-->
<!--AAdmin Content-->
<div class="admin-content">
<div class="button-group">
    <a href="create.html" class="btn btn-big">Add Users</a>
    <a href="index.php" class="btn btn-big">Manage Users</a>
</div>
<div class="content">
    <h2 class="page-title">Manage Users</h2>
    <table>
     <thead>
        <th>SN</th>
        <th>Username</th>
        <th>Role</th>
        <th colspan="2">Action</th>
     </thead>
      <tbody>
      <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['role'] . "</td>";
                echo "<td><a href='showUpdate.php?id=" . $row["id"] . "' class='edit'>Edit</a></td>";
                echo "<td><a href='delete.php?id=" . $row["id"] . "' class='delete'>Delete</a></td>";
                echo "</tr>";
            }
             $conn->close();
            ?>
      </tbody>
    </table>
</div>
</div> 
<!--//Admin Content-->

</div>
<!--// Page Wrapper-->
</div>
</body>
</html>