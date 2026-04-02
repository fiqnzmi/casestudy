<?php include('../auth/session.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - EDMS</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

<div class="d-flex">

    <!-- SIDEBAR -->
    <div class="bg-dark text-white p-3 vh-100" style="width: 250px;">
        <h4 class="text-center">📂 EDMS</h4>
        <hr>

        <ul class="nav flex-column">
            <li class="nav-item mb-2">
                <a href="dashboard.php" class="nav-link text-white">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="category.php" class="nav-link text-white">
                    <i class="bi bi-tags"></i> Categories
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="upload.php" class="nav-link text-white">
                    <i class="bi bi-upload"></i> Upload
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="document_list.php" class="nav-link text-white">
                    <i class="bi bi-file-earmark-text"></i> Documents
                </a>
            </li>

            <li class="nav-item mt-3">
                <a href="../auth/logout.php" class="nav-link text-danger">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </li>
        </ul>
    </div>

    <!-- MAIN CONTENT -->
    <div class="flex-grow-1">

        <!-- TOP NAVBAR -->
        <nav class="navbar navbar-light bg-light shadow-sm px-4">
            <span class="navbar-brand">Dashboard</span>
            <span>Welcome, <b><?= $_SESSION['user'] ?></b></span>
        </nav>

        <!-- CONTENT -->
        <div class="container mt-4">

            <div class="row g-4">

                <!-- CARD 1 -->
                <div class="col-md-4">
                    <div class="card shadow text-center">
                        <div class="card-body">
                            <i class="bi bi-tags fs-1 text-primary"></i>
                            <h5 class="mt-2">Categories</h5>
                            <p>Manage document categories</p>
                            <a href="category.php" class="btn btn-primary btn-sm">Open</a>
                        </div>
                    </div>
                </div>

                <!-- CARD 2 -->
                <div class="col-md-4">
                    <div class="card shadow text-center">
                        <div class="card-body">
                            <i class="bi bi-upload fs-1 text-success"></i>
                            <h5 class="mt-2">Upload</h5>
                            <p>Upload new documents</p>
                            <a href="upload.php" class="btn btn-success btn-sm">Upload</a>
                        </div>
                    </div>
                </div>

                <!-- CARD 3 -->
                <div class="col-md-4">
                    <div class="card shadow text-center">
                        <div class="card-body">
                            <i class="bi bi-file-earmark-text fs-1 text-warning"></i>
                            <h5 class="mt-2">Documents</h5>
                            <p>View all documents</p>
                            <a href="document_list.php" class="btn btn-warning btn-sm">View</a>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

</body>
</html>