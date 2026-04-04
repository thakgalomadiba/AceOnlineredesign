<?php
session_start();
require 'public/partials/db.php';
include 'public/partials/header.php';

// Redirect guests to login
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit;
}

$customerId = (int) $_SESSION['customer_id'];
$orderSuccess = false;
$orderNumber = '';
$productsInCart = [];
$total = 0;
$cartId = null;

// =======================
// Get active cart
// =======================
$stmt = $conn->prepare("SELECT id FROM cart WHERE customer_id = ? AND status = 'active' LIMIT 1");
$stmt->bind_param("i", $customerId);
$stmt->execute();
$result = $stmt->get_result();
$cart = $result->fetch_assoc();

if ($cart) {
    $cartId = $cart['id'];
}

// =======================
// Fetch cart items
// =======================
if ($cartId) {
    $stmt = $conn->prepare("
        SELECT 
            ci.product_id,
            ci.quantity,
            ci.unit_price,
            p.name,
            p.stock_quantity
        FROM cart_items ci
        INNER JOIN products p ON ci.product_id = p.id
        WHERE ci.cart_id = ?
    ");
    $stmt->bind_param("i", $cartId);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($item = $result->fetch_assoc()) {
        $subtotal = $item['unit_price'] * $item['quantity'];
        $total += $subtotal;

        $productsInCart[] = [
            'id' => $item['product_id'],
            'name' => $item['name'],
            'price' => $item['unit_price'],
            'quantity' => $item['quantity'],
            'subtotal' => $subtotal,
            'stock_quantity' => $item['stock_quantity']
        ];
    }
}

// =======================
// Handle Place Order
// =======================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($productsInCart)) {

    // Generate order number
    $orderNumber = 'ACE-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));

    $subtotal = $total;
    $shippingFee = 0.00;
    $discountAmount = 0.00;
    $totalAmount = $subtotal + $shippingFee - $discountAmount;

    // Insert order
    $stmt = $conn->prepare("
        INSERT INTO orders (
            customer_id, 
            address_id, 
            order_number, 
            status, 
            subtotal, 
            shipping_fee, 
            discount_amount, 
            total_amount, 
            payment_status, 
            created_at
        ) VALUES (?, NULL, ?, 'pending', ?, ?, ?, ?, 'unpaid', NOW())
    ");
    $stmt->bind_param("isdddd", $customerId, $orderNumber, $subtotal, $shippingFee, $discountAmount, $totalAmount);

    if ($stmt->execute()) {
        $orderId = $stmt->insert_id;

        // Insert order items + reduce stock
        foreach ($productsInCart as $item) {
            $lineTotal = $item['price'] * $item['quantity'];

            // Insert order item
            $stmtItem = $conn->prepare("
                INSERT INTO order_items (
                    order_id,
                    product_id,
                    product_name,
                    product_price,
                    quantity,
                    line_total
                ) VALUES (?, ?, ?, ?, ?, ?)
            ");
            $stmtItem->bind_param(
                "iisdid",
                $orderId,
                $item['id'],
                $item['name'],
                $item['price'],
                $item['quantity'],
                $lineTotal
            );
            $stmtItem->execute();

            // Reduce stock
            $stmtStock = $conn->prepare("
                UPDATE products
                SET stock_quantity = stock_quantity - ?
                WHERE id = ? AND stock_quantity >= ?
            ");
            $stmtStock->bind_param("iii", $item['quantity'], $item['id'], $item['quantity']);
            $stmtStock->execute();
        }

        // Mark cart as converted
        $stmtCart = $conn->prepare("UPDATE cart SET status = 'converted' WHERE id = ?");
        $stmtCart->bind_param("i", $cartId);
        $stmtCart->execute();

        $orderSuccess = true;
    }
}
?>

<div class="container">
    <h1>Checkout</h1>

    <?php if ($orderSuccess): ?>
        <p style="color:green;">Thank you! Your order has been placed successfully.</p>
        <p><strong>Order Number:</strong> <?= htmlspecialchars($orderNumber) ?></p>
        <a href="products.php" class="primary-btn">Continue Shopping</a>

    <?php elseif (!empty($productsInCart)): ?>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productsInCart as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td>R<?= number_format($item['price'], 2) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>R<?= number_format($item['subtotal'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Total: R<?= number_format($total, 2) ?></h3>

        <form method="POST">
            <button type="submit" class="primary-btn">Place Order</button>
        </form>

    <?php else: ?>
        <p>Your cart is empty. <a href="products.php">Go back to shop</a>.</p>
    <?php endif; ?>
</div>

<?php include 'public/partials/footer.php'; ?>