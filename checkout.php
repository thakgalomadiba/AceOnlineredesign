<?php
session_start();
require 'public/partials/db.php'; // Database connection
include 'public/partials/header.php';

// Redirect guests to login
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit;
}

// Handle order submission
$orderSuccess = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_data'])) {
    $customer_id = $_SESSION['customer_id'];
    $cart_data = json_decode($_POST['cart_data'], true); // Cart sent from JS

    if (!empty($cart_data)) {
        $total_price = 0;

        // Calculate total
        foreach ($cart_data as $item) {
            $stmt = $conn->prepare("SELECT price FROM products WHERE id=?");
            $stmt->bind_param("i", $item['id']);
            $stmt->execute();
            $stmt->bind_result($price);
            $stmt->fetch();
            $total_price += $price * $item['quantity'];
            $stmt->close();
        }

        // Insert order
        $stmt = $conn->prepare("INSERT INTO orders (customer_id, total, created_at) VALUES (?, ?, NOW())");
        $stmt->bind_param("id", $customer_id, $total_price);
        if ($stmt->execute()) {
            $order_id = $conn->insert_id;

            // Insert order items
            foreach ($cart_data as $item) {
                $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
                $stmt->bind_param("iii", $order_id, $item['id'], $item['quantity']);
                $stmt->execute();
                $stmt->close();
            }

            $orderSuccess = true;
        }
        $stmt->close();
    }
}
?>

<div class="container">
<h1>Checkout</h1>

<?php if ($orderSuccess): ?>
    <p style="color:green;">Thank you! Your order has been placed.</p>
<?php else: ?>
    <div id="checkout-container"></div>
    <div style="margin-top:20px;">
        <strong>Total Items: </strong><span id="checkout-total-items">0</span><br>
        <strong>Total Price: </strong>R<span id="checkout-total-price">0.00</span><br><br>
        <form id="checkout-form" method="POST">
            <input type="hidden" name="cart_data" id="cart_data">
            <button type="submit" class="primary-btn">Place Order</button>
        </form>
    </div>
<?php endif; ?>
</div>

<script src="public/assets/checkout.js" defer></script>

<?php include 'public/partials/footer.php'; ?>
