<?php
session_start();
require 'public/partials/db.php';

// =======================
// TEMP: fake logged-in user for testing
// Remove this later once login works properly
// =======================
if (!isset($_SESSION['customer_id'])) {
    $_SESSION['customer_id'] = 1;
}

$customerId = (int) $_SESSION['customer_id'];

// =======================
// Get product ID
// =======================
$productId = isset($_POST['product_id']) ? (int) $_POST['product_id'] : 0;

if ($productId <= 0) {
    die("Invalid product.");
}

// =======================
// Check product exists
// =======================
$stmt = $conn->prepare("SELECT id, price, stock_quantity FROM products WHERE id = ? AND is_active = 1 LIMIT 1");
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die("Product not found.");
}

if ($product['stock_quantity'] <= 0) {
    die("This product is out of stock.");
}

// =======================
// Find active cart
// =======================
$stmt = $conn->prepare("SELECT id FROM cart WHERE customer_id = ? AND status = 'active' LIMIT 1");
$stmt->bind_param("i", $customerId);
$stmt->execute();
$result = $stmt->get_result();
$cart = $result->fetch_assoc();

if ($cart) {
    $cartId = $cart['id'];
} else {
    $stmt = $conn->prepare("INSERT INTO cart (customer_id, status) VALUES (?, 'active')");
    $stmt->bind_param("i", $customerId);
    $stmt->execute();
    $cartId = $stmt->insert_id;
}

// =======================
// Check if already in cart
// =======================
$stmt = $conn->prepare("SELECT id, quantity FROM cart_items WHERE cart_id = ? AND product_id = ? LIMIT 1");
$stmt->bind_param("ii", $cartId, $productId);
$stmt->execute();
$result = $stmt->get_result();
$existingItem = $result->fetch_assoc();

if ($existingItem) {
    $newQty = $existingItem['quantity'] + 1;

    if ($newQty > $product['stock_quantity']) {
        $newQty = $product['stock_quantity'];
    }

    $stmt = $conn->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
    $stmt->bind_param("ii", $newQty, $existingItem['id']);
    $stmt->execute();
} else {
    $qty = 1;
    $unitPrice = $product['price'];

    $stmt = $conn->prepare("INSERT INTO cart_items (cart_id, product_id, quantity, unit_price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $cartId, $productId, $qty, $unitPrice);
    $stmt->execute();
}

// Redirect to cart
header("Location: cart.php");
exit;
?>