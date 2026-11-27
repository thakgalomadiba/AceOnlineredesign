
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Detect whether the application is running locally or on InfinityFree.
$isLocal = in_array($_SERVER['HTTP_HOST'] ?? '', [
    'localhost',
    '127.0.0.1'
]);

if ($isLocal) {
    // Local XAMPP database
    $servername = "localhost";
    $username   = "root";
    $password   = "";
    $dbname     = "ace_online_v2";
} else {
    // InfinityFree database
    $servername = "sql303.infinityfree.com";
    $username   = "if0_43397433";
    $password   = "Ditiromaboa13";
    $dbname     = "if0_43397433_ace_online_v2";
}

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>
