<?php
// Load products
$productsFile = 'products.json';
$products = [];
if (file_exists($productsFile)) {
    $products = json_decode(file_get_contents($productsFile), true);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout - ACE Online</title>
  <link rel="stylesheet" href="public/assets/style.css">
</head>
<body>

<?php include 'public/partials/header.php'; ?>

<section class="checkout-section">
  <div class="container">
    <h1>Checkout</h1>
    <div id="checkout-items"></div>

    <div class="checkout-summary">
      <p>Subtotal: R<span id="checkout-subtotal">0.00</span></p>
      <p>Total: R<span id="checkout-total">0.00</span></p>
    </div>

    <button id="place-order-btn" class="primary-btn">Place Order</button>
  </div>
</section>

<script src="public/assets/js/checkout.js"></script>
</body>
</html>
