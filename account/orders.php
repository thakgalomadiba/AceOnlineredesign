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

// Fetch orders for this customer
$stmt = $conn->prepare("
    SELECT o.id, o.total, o.created_at, o.status
    FROM orders o
    WHERE o.customer_id = ?
    ORDER BY o.created_at DESC
");
$stmt->bind_param("i", $customerId);
$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);
?>

<div class="container">
    <h1>My Orders</h1>

    <?php if (!empty($orders)): ?>
        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>Order ID</th>
                <th>Date</th>
                <th>Total</th>
                <th>Status</th>
                <th>Details</th>
            </tr>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td><?= date("d M Y", strtotime($order['created_at'])) ?></td>
                    <td>R<?= number_format($order['total'], 2) ?></td>
                    <td><?= htmlspecialchars($order['status']) ?></td>
                    <td><a href="order_details.php?id=<?= $order['id'] ?>">View</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>You have not placed any orders yet. <a href="../products.php">Start shopping</a>.</p>
    <?php endif; ?>
</div>

<?php include '../public/partials/footer.php'; ?>