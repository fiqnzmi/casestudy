<?php
session_start();
include('config/db.php');

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

// prevent back
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$msg = "";

if (isset($_POST['upload'])) {

    $title = trim($_POST['title']);
    $category = $_POST['category'];

    // VALIDATION
    if (empty($title)) {
        $msg = "Title is required!";
    } elseif (empty($_FILES['file']['name'])) {
        $msg = "File is required!";
    } else {

        // Check file limit
        $count = $conn->query("SELECT COUNT(*) as total FROM documents WHERE category_id=$category")->fetch_assoc()['total'];
        $limit = $conn->query("SELECT file_limit FROM categories WHERE id=$category")->fetch_assoc()['file_limit'];

        if ($count >= $limit) {
            $msg = "File limit reached for this category!";
        } else {
            $filename = time() . "_" . basename($_FILES['file']['name']);
            $path = "uploads/" . $filename;

            move_uploaded_file($_FILES['file']['tmp_name'], $path);

            $stmt = $conn->prepare("INSERT INTO documents (title, category_id, file_path) VALUES (?,?,?)");
            $stmt->bind_param("sis", $title, $category, $path);
            $stmt->execute();

            file_put_contents("logs/log.txt", "Uploaded: $title\n", FILE_APPEND);

            $msg = "Upload successful!";
        }
    }
}

$cat = $conn->query("SELECT * FROM categories");
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploads Documents</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="navbar">
        <div class="nav-left">
            <span class="logo">EDMS</span>
            <span style="margin-left:15px;">Welcome, <?= $_SESSION['user']; ?></span>
        </div>

        <div class="nav-right">
            <a href="dashboard.php">Dashboard</a>
            <a href="categories.php">Categories</a>
            <a href="upload.php">Upload</a>
            <a href="documents.php">Documents</a>
            <a href="logout.php" class="logout">Logout</a>
        </div>
    </div>

    <div class="container">
    <div class="form-box">

        <h2>Upload</h2>
        <p style="color:red;"><?= $msg ?></p>

        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Title"><br>

            <select name="category">
                <?php while ($c = $cat->fetch_assoc()) { ?>
                    <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
                <?php } ?>
            </select><br>

            <input type="file" name="file"><br>
            <button name="upload">Upload</button>
        </form>

    </div>
</div>
</body>

</html>