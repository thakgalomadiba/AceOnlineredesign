<?php
session_start();
require 'public/partials/db.php';

// User must be logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit;
}

$customerId = (int)$_SESSION['customer_id'];
$productsInCart = [];
$total = 0;

// =======================
// Get active cart
// =======================
$stmt = $conn->prepare("SELECT id FROM cart WHERE customer_id = ? AND status = 'active' LIMIT 1");
$stmt->bind_param("i", $customerId);
$stmt->execute();
$cartResult = $stmt->get_result();
$cart = $cartResult->fetch_assoc();

$cartId = $cart ? $cart['id'] : null;

// =======================
// Handle Remove Item
// =======================
if (isset($_GET['remove']) && $cartId) {
    $productId = (int)$_GET['remove'];

    $stmt = $conn->prepare("DELETE FROM cart_items WHERE cart_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $cartId, $productId);
    $stmt->execute();

    header("Location: cart.php");
    exit;
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
            p.stock_quantity,
            pi.image_path
        FROM cart_items ci
        INNER JOIN products p ON ci.product_id = p.id
        LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.is_primary = 1
        WHERE ci.cart_id = ?
        ORDER BY ci.id DESC
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
            'image' => $item['image_path'] ?: 'default.png'
        ];
    }
}
?>

<?php include 'public/partials/header.php'; ?>

<div class="container">
    <h2>Your Cart</h2>

    <?php if (!empty($productsInCart)): ?>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productsInCart as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td>
                            <img 
                                src="public/uploads/products/<?= htmlspecialchars($item['image']) ?>" 
                                alt="<?= htmlspecialchars($item['name']) ?>" 
                                width="60"
                            >
                        </td>
                        <td>R<?= number_format($item['price'], 2) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>R<?= number_format($item['subtotal'], 2) ?></td>
                        <td>
                            <a href="cart.php?remove=<?= $item['id'] ?>" class="btn-remove" onclick="return confirm('Remove this item from cart?')">
                                Remove
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Total: R<?= number_format($total, 2) ?></h3>
        <a href="checkout.php" class="btn-checkout">Proceed to Checkout</a>
    <?php else: ?>
        <p>Your cart is empty. <a href="products.php">Go back to shop</a>.</p>
    <?php endif; ?>
</div>

<?php include 'public/partials/footer.php'; ?>