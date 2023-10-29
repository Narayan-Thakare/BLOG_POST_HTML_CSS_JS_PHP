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
$sql = "SELECT id, title, body, image, topic FROM post_tbl";

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
    <title>Admin Section - Manage Posts</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Candal|Lora" rel="stylesheet">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/admin.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
    <script src="../../js/script.js"></script>

    <style>
        /* General Styles */
        body {
            font-family: 'Your Font Family', sans-serif; /* Replace with desired font */
            margin: 0;
            padding: 0;
        }

        /* Header Styles */
        header {
            background: #800080;
            color: white;
            text-align: center;
            padding: 10px 0;
        }

        .logo-text {
            font-size: 28px;
            font-weight: bold;
        }

        /* Admin Wrapper Styles */
        .admin-wrapper {
            display: flex;
        }

        /* Left Sidebar Styles */
        .left-sidebar {
            flex: 2;
            background: #b761ce;
            padding: 20px;
            color: white;
        }

        .left-sidebar ul {
            list-style: none;
            padding: 0;
        }

        .left-sidebar ul li {
            margin-bottom: 10px;
        }

        .left-sidebar ul li a {
            color: white;
            text-decoration: none;
        }

        .left-sidebar ul li a:hover {
            text-decoration: underline;
        }

        /* Admin Content Styles */
        .admin-content {
            flex: 8;
            padding: 20px;
        }

        .button-group {
            margin-bottom: 20px;
        }

        .btn {
            background: #800080;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
        }

        .btn:hover {
            background: #025e63;
        }

        .content {
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .page-title {
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 1.1rem;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #d3d3d3;
        }

        th {
            background: #800080;
            color: white;
        }

        /* Link Styles for Edit, Delete, and Publish Actions */
        .edit, .delete, .publish {
            color: #800080;
            text-decoration: none;
        }

        .edit:hover, .delete:hover, .publish:hover {
            text-decoration: underline;
        }



        /* Button Styles */
.btn {
    display: inline-block;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    border: none;
    border-radius: 5px;
    font-weight: bold;
    cursor: pointer;
}

.btn.create-post-button {
    background-color: #800080;
    color: white;
}

.btn.create-post-button:hover {
    background-color: #025e63;
}

.btn.manage-posts-button {
    background-color: #b761ce;
    color: white;
}

.btn.manage-posts-button:hover {
    background-color: #a94eba;
}



    </style>
</head>

<body>
    <header>
        <div class="logo">
            <h1 class="logo-text"><span>&nbsp;My Blog</span>Website </h1>
        </div>
        <ul class="nav">
            <li>
                <a href="#">
                    <i class="fa fa-user"></i>
                    <span class="username">Narayan</span>
                </a>
                <a href="logout.php">
                    <i class="fa fa-sign-out"></i>&nbsp;&nbsp;
                </a>
            </li>
        </ul>
    </header>

    <div class="admin-wrapper">
        <div class="left-sidebar">
            <ul>
                <li><a href="index.php">Manage Posts</a></li>
                <li><a href="../users/index.php">Manage Users</a></li>
                <li><a href="\admin\posts\ShowPublish.php">publish</a></li>
            </ul>
        </div>

        <div class="admin-content">
        <div class="button-group">
    <a href="create.html" class="btn btn-big">Create New Post</a>
    <a href="index.php" class="btn btn-big">View All Posts</a>
</div>

            <div class="content">
                <h2 class="page-title">Manage Posts</h2>
                <table>
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Title</th>
                            <th>Body</th>
                            <th>Image</th>
                            <th>Topic</th>
                            <th colspan="5">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['title'] . "</td>";
                            echo "<td>" . $row['body'] . "</td>";
                            echo '<td><img src="images/' . $row['image'] . '" width="120" height="120"></td>';
                            echo "<td>" . $row['topic'] . "</td>";
                            echo "<td><a href='showUpdate.php?id=" . $row["id"] . "' class='edit'>Edit</a></td>";
                            echo "<td><a href='delete.php?title=" . $row["title"] . "' class='delete'>Delete</a></td>";
                            echo "<td><a href='publish.php?id=" . $row["id"] . "' class='publish'>Publish</a></td>";
                            echo "</tr>";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
