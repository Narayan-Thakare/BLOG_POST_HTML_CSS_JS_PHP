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
    $sql = "SELECT name,description FROM topic_tbl WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // "i" represents an integer, adjust the type if needed

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $name = $row['name'];
            $description = $row['description'];
           
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
    <link
        href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://celionatti.github.io/blog-template/assets/css/admin-style.css">
    <title>Admin Section - Add Topic</title>
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
    <script src="https://cdn.ckeditor.com/4.17.0/standard/ckeditor.js"></script>

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
    <li><a href="../users/index.php">Manage Users</a></li>
    <li><a href="index.php">Manage Topics</a></li>
</ul>

</div>
<!--//Left Sidebar-->
<!--AAdmin Content-->
<div class="admin-content">
<a href="index.php">Back</a>
 <div class="content">
    <h2 class="page-title">Update Topic</h2>
    <form action="update.php" method="post" > 
    <input type="hidden" name="id" value="<?php echo $id; ?>">

        <div>
            <label>Name</label>
            <input type="text" name="name" id="name"  value="<?php echo $name; ?>" class="text-input">
        </div>
        <div class="input-group">
             <label for="post-editor">Body</label>
            <textarea name="description" id="description"><?php echo preg_replace('/\s+/', ' ', $description); ?></textarea>
        </div>
         <div>
            <button type="submit" class="btn btn-big"> Update Topic</button>
        </div>
    </form>
</div> 
</div> 
<!--//Admin Content-->


<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script src="https://celionatti.github.io/blog-template/assets/js/admin.js"></script>
<script src="https://celionatti.github.io/blog-template/assets/js/post_quill_editor.js"></script>
<!-- <script src="../../assets/js/post_quill_editor.js"></script> -->

<script>
    CKEDITOR.replace('description');
// PREVIEW POST IMAGE
const imageBtn = document.querySelector('.image-btn');
const imageInput = document.querySelector('.image-input');
const chooseImageLabel = document.querySelector('.choose-image-label');

imageBtn.addEventListener('click', function () {
    imageInput.click();
});

imageInput.addEventListener('change', function () {
    const file = imageInput.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            imageBtn.style.backgroundImage = `url(${e.target.result})`;
            imageBtn.style.height = '150px';
            imageBtn.style.border = 'none';
            chooseImageLabel.classList.toggle('hide');
        };
        reader.readAsDataURL(file);
    }
});
</script>
</div>
<!--// Page Wrapper-->
</div>
</body>
</html>