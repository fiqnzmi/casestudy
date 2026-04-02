<?php
session_start();

// DESTROY SESSION
session_unset();
session_destroy();

// PREVENT BACK BUTTON AFTER LOGOUT
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

header("Location: login.php");
exit();
?>