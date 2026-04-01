<?php
session_start();
require '../public/partials/db.php';

// Get order ID from URL
if (!isset($_GET['id'])) {
    die("Order ID not specified.");
}
$order_id = intval($_GET['id']);

// Fetch order info
$order_stmt = $conn->prepare("
    SELECT o.id, o.customer_id, o.total, o.created_at,
           c.name as customer_name, c.email, c.phone
    FROM orders o
    JOIN customers c ON o.customer_id = c.id
    WHERE o.id = ?
");
$order_stmt->bind_param("i", $order_id);
$order_stmt->execute();
$order_result = $order_stmt->get_result();
$order = $order_result->fetch_assoc();

if (!$order) {
    die("Order not found.");
}

// Fetch order items
$items_stmt = $conn->prepare("
    SELECT p.name, p.price, oi.quantity
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = ?
");
$items_stmt->bind_param("i", $order_id);
$items_stmt->execute();
$items_result = $items_stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order #<?= $order['id'] ?> Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Order Details - #<?= $order['id'] ?></h1>

<h2>Customer Info</h2>
<ul>
    <li><strong>Name:</strong> <?= htmlspecialchars($order['customer_name']) ?></li>
    <li><strong>Email:</strong> <?= htmlspecialchars($order['email']) ?></li>
    <li><strong>Phone:</strong> <?= htmlspecialchars($order['phone']) ?></li>
    <li><strong>Order Date:</strong> <?= $order['created_at'] ?></li>
</ul>

<h2>Products in Order</h2>
<table border="1">
    <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Subtotal</th>
    </tr>
    <?php while($item = $items_result->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($item['name']) ?></td>
        <td><?= $item['price'] ?></td>
        <td><?= $item['quantity'] ?></td>
        <td><?= $item['price'] * $item['quantity'] ?></td>
    </tr>
    <?php endwhile; ?>
    <tr>
        <td colspan="3"><strong>Total</strong></td>
        <td><strong><?= $order['total'] ?></strong></td>
    </tr>
</table>

</body>
</html>