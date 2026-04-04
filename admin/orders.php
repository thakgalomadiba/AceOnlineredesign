<?php
session_start();
$base_url = '../';
require $base_url . 'public/partials/db.php';
include $base_url . 'public/partials/header.php';

// =======================
// Handle status update
// =======================
if (isset($_POST['update_status'])) {
    $orderId = (int) $_POST['order_id'];
    $status = $_POST['status'];

    $allowedStatuses = ['pending', 'paid', 'processing', 'shipped', 'delivered', 'cancelled'];

    if (in_array($status, $allowedStatuses)) {
        $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $orderId);
        $stmt->execute();
    }

    header("Location: orders.php");
    exit;
}

// =======================
// Fetch all orders
// =======================
$sql = "
SELECT 
    o.id,
    o.order_number,
    o.status,
    o.payment_status,
    o.subtotal,
    o.shipping_fee,
    o.discount_amount,
    o.total_amount,
    o.created_at,
    c.full_name,
    c.email
FROM orders o
INNER JOIN customers c ON o.customer_id = c.id
ORDER BY o.created_at DESC
";

$result = $conn->query($sql);

if (!$result) {
    die("Orders query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Orders</title>
    <link rel="stylesheet" href="../public/assets/style.css">
</head>
<body>

<div class="container">
    <h1>Orders Management</h1>

    <?php if ($result->num_rows > 0): ?>
        <table border="1" cellpadding="10" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Order Number</th>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Subtotal</th>
                    <th>Shipping</th>
                    <th>Discount</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Update</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $order['id'] ?></td>
                        <td><?= htmlspecialchars($order['order_number']) ?></td>
                        <td><?= htmlspecialchars($order['full_name']) ?></td>
                        <td><?= htmlspecialchars($order['email']) ?></td>
                        <td>R<?= number_format($order['subtotal'], 2) ?></td>
                        <td>R<?= number_format($order['shipping_fee'], 2) ?></td>
                        <td>R<?= number_format($order['discount_amount'], 2) ?></td>
                        <td><strong>R<?= number_format($order['total_amount'], 2) ?></strong></td>
                        <td><?= htmlspecialchars($order['payment_status']) ?></td>
                        <td><?= htmlspecialchars($order['status']) ?></td>
                        <td><?= $order['created_at'] ?></td>
                        <td>
                            <form method="POST" style="display:flex; gap:5px;">
                                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                <select name="status">
                                    <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="paid" <?= $order['status'] === 'paid' ? 'selected' : '' ?>>Paid</option>
                                    <option value="processing" <?= $order['status'] === 'processing' ? 'selected' : '' ?>>Processing</option>
                                    <option value="shipped" <?= $order['status'] === 'shipped' ? 'selected' : '' ?>>Shipped</option>
                                    <option value="delivered" <?= $order['status'] === 'delivered' ? 'selected' : '' ?>>Delivered</option>
                                    <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                </select>
                                <button type="submit" name="update_status">Save</button>
                            </form>
                        </td>
                        <td>
                            <a href="order_details.php?id=<?= $order['id'] ?>">View</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No orders found.</p>
    <?php endif; ?>
</div>

</body>
</html>