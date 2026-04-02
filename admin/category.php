<?php
include('../auth/session.php');
include('../config/db.php');

// ADD
if(isset($_POST['add'])){
    $name = $_POST['name'];
    $limit = $_POST['limit'];

    $stmt = $conn->prepare("INSERT INTO categories (name, file_limit) VALUES (?, ?)");
    $stmt->bind_param("si", $name, $limit);
    $stmt->execute();
}

// DELETE
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $conn->query("DELETE FROM categories WHERE id=$id");
}

$result = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html>
<head>
<title>Categories</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

<div class="d-flex">

<?php include('layout.php'); ?>

<div class="flex-grow-1">

<nav class="navbar bg-light shadow-sm px-4">
    <h5>Categories</h5>
</nav>

<div class="container mt-4">

<div class="card p-3 shadow mb-4">
<form method="POST" class="row g-2">
    <div class="col-md-5">
        <input type="text" name="name" class="form-control" placeholder="Category Name" required>
    </div>
    <div class="col-md-5">
        <input type="number" name="limit" class="form-control" placeholder="File Limit" required>
    </div>
    <div class="col-md-2">
        <button name="add" class="btn btn-primary w-100">Add</button>
    </div>
</form>
</div>

<div class="card shadow p-3">
<table class="table table-hover">
<tr class="table-dark">
<th>Name</th>
<th>Limit</th>
<th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()){ ?>
<tr>
<td><?= htmlspecialchars($row['name']) ?></td>
<td><?= $row['file_limit'] ?></td>
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