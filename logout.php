<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Clear all session data
$_SESSION = [];

// Destroy session
session_destroy();

// Redirect to homepage
header("Location: /index.php");
exit();
