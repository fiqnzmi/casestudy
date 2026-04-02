<?php
include('../auth/session.php');
include('../config/db.php');

if(isset($_GET['delete'])){
    $id = $_GET['delete'];

    $file = $conn->query("SELECT file_path FROM documents WHERE id=$id")->fetch_assoc();
    unlink($file['file_path']);

    $conn->query("DELETE FROM documents WHERE id=$id");

    file_put_contents("../logs/log.txt", "Deleted file\n", FILE_APPEND);
}

$result = $conn->query("SELECT d.*, c.name as category FROM documents d JOIN categories c ON d.category_id=c.id");
?>

<!DOCTYPE html>
<html>
<head>
<title>Documents</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

<div class="d-flex">

<?php include('layout.php'); ?>

<div class="flex-grow-1">

<nav class="navbar bg-light shadow-sm px-4">
    <h5>Documents</h5>
</nav>

<div class="container mt-4">

<div class="card shadow p-3">
<table class="table table-hover">
<tr class="table-dark">
<th>Title</th>
<th>Category</th>
<th>File</th>
<th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()){ ?>
<tr>
<td><?= htmlspecialchars($row['title']) ?></td>
<td><?= $row['category'] ?></td>
<td>
<a href="<?= $row['file_path'] ?>" target="_blank" class="btn btn-info btn-sm">View</a>
</td>
<td>
<a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
</td>
</tr>
<?php } ?>

</table>
</div>

</div>
</div>
</div>

</body>
</html>