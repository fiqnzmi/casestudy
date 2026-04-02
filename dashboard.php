<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

// prevent back
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>



<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
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
</body>

</html>