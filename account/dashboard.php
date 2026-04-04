<?php
session_start();
require '../public/partials/db.php';
include '../public/partials/header.php';

// Redirect guests
if (!isset($_SESSION['customer_id'])) {
    header("Location: ../login.php");
    exit;
}

$customerId = (int)$_SESSION['customer_id'];

// Fetch customer info
$stmt = $conn->prepare("SELECT full_name, email, created_at FROM customers WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $customerId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<div class="container">
    <h1>My Account</h1>
    <h2>Welcome, <?= htmlspecialchars($user['full_name']) ?> 👋</h2>

    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    <p><strong>Member Since:</strong> <?= date("d M Y", strtotime($user['created_at'])) ?></p>

    <hr>

    <h3>Quick Links</h3>
    <ul>
        <li><a href="orders.php">📦 My Orders</a></li>
        <li><a href="settings.php">⚙️ Account Settings</a></li>
        <li><a href="../cart.php">🛒 View Cart</a></li>
        <li><a href="../checkout.php">💳 Checkout</a></li>
        <li><a href="../logout.php">🚪 Logout</a></li>
    </ul>
</div>

<?php include '../public/partials/footer.php'; ?>