<?php
include('../auth/session.php');
include('../config/db.php');

$categories = $conn->query("SELECT * FROM categories");

if(isset($_POST['upload'])){
    $title = $_POST['title'];
    $category_id = $_POST['category'];

    $file = $_FILES['file'];
    $target = "../uploads/" . basename($file['name']);

    $count = $conn->query("SELECT COUNT(*) as total FROM documents WHERE category_id=$category_id")->fetch_assoc()['total'];
    $limit = $conn->query("SELECT file_limit FROM categories WHERE id=$category_id")->fetch_assoc()['file_limit'];

    if($count >= $limit){
        echo "<div class='alert alert-danger'>File limit reached!</div>";
    } else {
        move_uploaded_file($file['tmp_name'], $target);

        $stmt = $conn->prepare("INSERT INTO documents (title, category_id, file_path) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $title, $category_id, $target);
        $stmt->execute();

        file_put_contents("../logs/log.txt", "Upload: $title\n", FILE_APPEND);

        echo "<div class='alert alert-success'>Upload success!</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Upload</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="d-flex">

<div class="bg-dark text-white p-3 vh-100" style="width: 250px;">
    <h4>EDMS</h4><hr>
    <a href="dashboard.php" class="text-white d-block">Dashboard</a>
    <a href="category.php" class="text-white d-block">Categories</a>
    <a href="upload.php" class="text-white d-block">Upload</a>
    <a href="document_list.php" class="text-white d-block">Documents</a>
</div>

<div class="flex-grow-1">

<nav class="navbar bg-light px-4 shadow-sm">
    <h5>Upload Document</h5>
</nav>

<div class="container mt-4">

<div class="card p-4 shadow" style="max-width:500px;">
<form method="POST" enctype="multipart/form-data">

<input type="text" name="title" class="form-control mb-3" placeholder="Title" required>

<select name="category" class="form-control mb-3">
<?php while($c = $categories->fetch_assoc()){ ?>
<option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
<?php } ?>
</select>

<input type="file" name="file" class="form-control mb-3" required>

<button name="upload" class="btn btn-success w-100">Upload</button>

</form>
</div>

</div>
</div>
</div>

</body>
</html>