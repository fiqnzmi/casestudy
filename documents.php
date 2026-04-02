<?php
session_start();
include('config/db.php');

// Protect page
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

/* ================= DELETE FUNCTION ================= */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // Get file info safely
    $stmt = $conn->prepare("SELECT * FROM documents WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if ($data) {
        $file = "uploads/" . basename($data['file_path']);

        if (file_exists($file)) {
            unlink($file);
        }

        // Delete from database
        $stmt = $conn->prepare("DELETE FROM documents WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // LOG activity
        file_put_contents("logs/log.txt", "Deleted: " . $data['title'] . "\n", FILE_APPEND);
    }

    header("Location: documents.php");
    exit();
}

/* ================= DISPLAY DATA ================= */
$result = $conn->query("
SELECT d.*, c.name 
FROM documents d 
JOIN categories c ON d.category_id = c.id
");
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

        <h2>Documents</h2>

        <table>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>File</th>
                <th>Action</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><a href="<?= $row['file_path'] ?>" target="_blank">View</a></td>
                    <td>
                        <a class="button" href="documents.php?delete=<?= $row['id'] ?>"
                            onclick="return confirm('Delete this file?')">
                            Delete
                        </a>
                    </td>
                </tr>
            <?php } ?>

        </table>

    </div>
</body>

</html>