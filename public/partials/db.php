<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database configuration
$servername = "localhost";     // Usually "localhost"
$username   = "root";          // Your MySQL username
$password   = "";              // Your MySQL password
$dbname     = "ace_online";    // Your database name

// Create MySQL connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Optional: set charset to avoid encoding issues
$conn->set_charset("utf8");

// Usage example: 
// $result = $conn->query("SELECT * FROM users");
// while ($row = $result->fetch_assoc()) { ... }
?>
