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

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Use prepared statements to protect against SQL injection
    $sql = "SELECT username,role FROM user_tbl WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // "i" represents an integer, adjust the type if needed

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $inputUsername = $row['username'];
            $role = $row['role'];
           
        } else {
            echo "No post found with the given ID.";
            exit();
        }
    } else {
        echo "Error executing the query: " . $stmt->error;
        exit();
    }

    $stmt->close();
} else {
    echo "Invalid request.";
    $conn->close();
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Section - update user</title>
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--Google Fonts-->
    <link href="https://fonts.googleapis.com/css?family=Candal|Lora" rel="stylesheet">
    <!--Custom Styling-->
    <link rel="stylesheet" href="../../css/style.css">
    <!--Admin Styling-->
    <link rel="stylesheet" href="../../css/admin.css">
    <!-- JQuery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!--CKeditor-->
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/super-build/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/super-build/translations/es.js"></script>

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
    <a href="create.html" class="btn btn-big">Add User</a>
    <a href="index.php" class="btn btn-big">Manage User</a>
</div>
<div class="content">
    <h2 class="page-title">Update User</h2>
    <form action="update.php" method="post">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
  
        <div>
             <label>Username</label>
             <input type="text" name="username" value="<?php echo $inputUsername; ?>" class="text-input">
       </div>
       
       <div>
        <label for="role">Role</label>
        <select name="role" id="role" class="text-input">
            <option value="User" <?php if ($role === "User") echo "selected"; ?>>User</option>
            <option value="Admin" <?php if ($role === "Admin") echo "selected"; ?>>Admin</option>
        </select>
    </div>
        <div>
            <button type="submit" class="btn btn-big">Update User</button>
        </div>
    </form>
</div>

</div> 
<!--//Admin Content-->

</div>
<!--// Page Wrapper-->
</div>
</body>
</html>