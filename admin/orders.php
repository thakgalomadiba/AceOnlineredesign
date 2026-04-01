<?php
session_start();
$base_url = '../'; // relative path from admin folder to project root
require $base_url . 'public/partials/db.php';
include $base_url . 'public/partials/header.php';

// Update order status
if (isset($_POST['update_status'])) {
    $order_id = intval($_POST['order_id']);
    $status = $_POST['status'];
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $order_id);
    $stmt->execute();
}

// Fetch orders
$orders = $conn->query("SELECT o.id, o.status, o.total, c.name as customer_name
                        FROM orders o
                        JOIN customers c ON o.customer_id = c.id
                        ORDER BY o.id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Orders</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Customer Orders</h1>

<table border="1">
    <tr>
        <th>ID</th><th>Customer</th><th>Total</th><th>Status</th><th>Actions</th>
    </tr>
    <?php while($row = $orders->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['customer_name']) ?></td>
        <td><?= $row['total'] ?></td>
        <td><?= $row['status'] ?></td>
        <td>
            <form method="POST" style="display:inline;">
                <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
                <select name="status">
                    <option value="Pending" <?= $row['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="Shipped" <?= $row['status'] === 'Shipped' ? 'selected' : '' ?>>Shipped</option>
                    <option value="Delivered" <?= $row['status'] === 'Delivered' ? 'selected' : '' ?>>Delivered</option>
                </select>
                <button type="submit" name="update_status">Update</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
</body>
</html>