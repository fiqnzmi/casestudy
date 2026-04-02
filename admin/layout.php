<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
?>

<!-- SIDEBAR -->
<div class="bg-dark text-white p-3 vh-100" style="width:250px;">
    
    <h4 class="text-center">
        📁 <b>EDMS</b>
    </h4>
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

        <li class="nav-item mt-4">
            <a href="../auth/logout.php" class="nav-link text-danger">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </li>

    </ul>
</div>