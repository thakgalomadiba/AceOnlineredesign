<?php
session_start();
require 'public/partials/db.php'; // your DB connection

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle Remove Item
if (isset($_GET['remove'])) {
    $id = $_GET['remove'];
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
        header("Location: cart.php");
        exit;
    }
}

// Calculate total
$total = 0;
foreach ($_SESSION['cart'] as $id => $quantity) {
    $stmt = $conn->prepare("SELECT name, price FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $total += $product['price'] * $quantity;
    $productsInCart[] = [
        'id' => $id,
        'name' => $product['name'],
        'price' => $product['price'],
        'quantity' => $quantity,
        'subtotal' => $product['price'] * $quantity
    ];
}
?>

<?php include 'public/partials/header.php'; ?>

<div class="container">
    <h2>Your Cart</h2>
    <?php if (!empty($_SESSION['cart'])): ?>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Product</th>
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
                        <td>R<?= number_format($item['price'], 2) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>R<?= number_format($item['subtotal'], 2) ?></td>
                        <td><a href="cart.php?remove=<?= $item['id'] ?>" class="btn-remove">Remove</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h3>Total: R<?= number_format($total, 2) ?></h3>
        <a href="checkout.php" class="btn-checkout">Proceed to Checkout</a>
    <?php else: ?>
        <p>Your cart is empty. <a href="index.php">Go back to shop</a>.</p>
    <?php endif; ?>
</div>

<?php include 'public/partials/footer.php'; ?>