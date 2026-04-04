<?php
session_start();
require '../public/partials/db.php';
include '../public/partials/header.php';

// Check if user is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: ../login.php");
    exit;
}

// Get order ID from URL
$order_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$customer_id = $_SESSION['customer_id'];

if ($order_id <= 0) {
    echo "<p>Invalid order ID.</p>";
    exit;
}

// Fetch order info
$stmt = $conn->prepare("
    SELECT id, total, status, created_at
    FROM orders
    WHERE id = ? AND customer_id = ?
    LIMIT 1
");
$stmt->bind_param("ii", $order_id, $customer_id);
$stmt->execute();
$orderResult = $stmt->get_result();
$order = $orderResult->fetch_assoc();

if (!$order) {
    echo "<p>Order not found.</p>";
    exit;
}

// Fetch order items
$stmtItems = $conn->prepare("
    SELECT oi.quantity, p.name, p.price
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = ?
");
$stmtItems->bind_param("i", $order_id);
$stmtItems->execute();
$itemsResult = $stmtItems->get_result();
$orderItems = $itemsResult->fetch_all(MYSQLI_ASSOC);
?>

<div class="container">
    <h1>Order #<?= $order['id'] ?></h1>
    <p>Status: <?= htmlspecialchars($order['status']) ?></p>
    <p>Placed on: <?= htmlspecialchars($order['created_at']) ?></p>
    <p>Total: R<?= number_format($order['total'], 2) ?></p>

    <h2>Items</h2>
    <table border="1">
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
        </tr>
        <?php foreach ($orderItems as $item): ?>
        <tr>
            <td><?= htmlspecialchars($item['name']) ?></td>
            <td>R<?= number_format($item['price'], 2) ?></td>
            <td><?= $item['quantity'] ?></td>
            <td>R<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <a href="orders.php">← Back to Orders</a>
</div>

<?php include '../public/partials/footer.php'; ?>