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

if (isset($_POST['add'])) {
    $name = trim($_POST['name']);
    $limit = $_POST['limit'];

    // VALIDATION
    if (empty($name)) {
        $msg = "Category name is required!";
    } elseif (empty($limit) || $limit <= 0) {
        $msg = "File limit must be greater than 0!";
    } else {
        $stmt = $conn->prepare("INSERT INTO categories (name, file_limit) VALUES (?,?)");
        $stmt->bind_param("si", $name, $limit);
        $stmt->execute();

        $msg = "Category added successfully!";
    }
}

$result = $conn->query("SELECT * FROM categories");
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
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

        <h2>Categories</h2>

        <div class="form-inline">
            <form method="POST">
                <input type="text" name="name" placeholder="Category Name">
                <input type="number" name="limit" placeholder="File Limit">
                <button name="add">Add</button>
            </form>
        </div>

        <table>
            <tr>
                <th>Name</th>
                <th>Limit</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= $row['file_limit'] ?></td>
                </tr>
            <?php } ?>
        </table>

    </div>
</body>

</html>