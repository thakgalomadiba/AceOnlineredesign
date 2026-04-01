<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['customer_id']) || !isset($_SESSION['customer_role']) || $_SESSION['customer_role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
?>