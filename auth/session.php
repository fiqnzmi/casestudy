<?php
session_start();

// BLOCK if not logged in
if(!isset($_SESSION['user'])){
    header("Location: ../auth/login.php");
    exit();
}

// PREVENT BACK BUTTON CACHE
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>