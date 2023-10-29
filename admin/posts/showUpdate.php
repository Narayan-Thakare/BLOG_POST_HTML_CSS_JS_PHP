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
    $sql = "SELECT title, body, image, topic FROM post_tbl WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // "i" represents an integer, adjust the type if needed

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $title = $row['title'];
            $body = $row['body'];
            $image = $row['image'];
            $topic = $row['topic'];
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
    <title>Admin Section - update Post</title>
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
                    <span class="username">Narayan</span>
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
    <li><a href="index.php">Manage Posts</a></li>
    <li><a href="../users/index.php">Manage Users</a></li>
    <li><a href="../topics/index.php">Manage Topics</a></li>
</ul>

</div>
<!--//Left Sidebar-->
<!--AAdmin Content-->
<div class="admin-content">

<a href="index.php">Back</a>

<div class="content">
 <h2 class="page-title">Update Post</h2>
    <form action="update.php" method="post" enctype="multipart/form-data"> 
    <input type="hidden" name="id" value="<?php echo $id; ?>">

        <div>
            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="<?php echo $title; ?>" class="text-input">
        </div>

        <div class="input-group">
             <label for="post-editor">Body</label>
            <textarea name="body" id="body"><?php echo preg_replace('/\s+/', ' ', $body); ?></textarea>
        </div>
        
        <div class="image-box">
         <label for="image">Image</label>
         <input type="file" name="image" id="image" accept="image/*">
          <!-- Display the current image if it exists -->
         <img src="images/" alt="Current Image">
        </div>

        
        <div>
            <label for="topic">Topic</label>
            <select name="topic" id="topic" class="text-input">
                <option value="Spring Java" <?php if ($topic === "Spring Java") echo "selected"; ?> >Spring Java</option>
                <option value="Core Java" <?php if ($topic === "Core Java") echo "selected"; ?> >Core Java</option>
                <option value="Servlet and JSP" <?php if ($topic === "Servlet and JSP") echo "selected"; ?> >Servlet and JSP</option>
             </select>
        </div>
        <div>
            <button type="submit" class="btn btn-big">Update Post</button>
        </div>
    </form>
</div>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script src="https://celionatti.github.io/blog-template/assets/js/admin.js"></script>
<script src="https://celionatti.github.io/blog-template/assets/js/post_quill_editor.js"></script>
<!-- <script src="../../assets/js/post_quill_editor.js"></script> -->
<script>
     CKEDITOR.replace('body');
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
<!--//Admin Content-->

</div>
<!--// Page Wrapper-->
</div>
</body>
</html>