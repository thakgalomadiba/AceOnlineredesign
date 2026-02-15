<?php
// Load categories dynamically from JSON for dynamic menus
$categoriesFile = 'categories.json'; 
$categories = [];
if (file_exists($categoriesFile)) {
    $categories = json_decode(file_get_contents($categoriesFile), true);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ACE Online SA</title>
  <link rel="stylesheet" href="public/assets/style.css">
</head>
<body>

<header class="main-header">
  <div class="container header-content">

    <!-- Logo -->
    <div class="logo">
      <a href="/index.php">ACE ONLINE SA</a>
    </div>

    <!-- Navigation -->
    <nav class="main-nav">
      <a href="/index.php">Home</a>

      <?php if (!empty($categories)): ?>
          <?php foreach ($categories as $cat): ?>
              <div class="nav-dropdown">
                  <a href="#"><?php echo htmlspecialchars($cat['name']); ?> ▾</a>
                  <?php if (!empty($cat['subcategories'])): ?>
                      <div class="dropdown-content">
                          <?php foreach ($cat['subcategories'] as $sub): ?>
                              <a href="#"><?php echo htmlspecialchars($sub); ?></a>
                          <?php endforeach; ?>
                      </div>
                  <?php endif; ?>
              </div>
          <?php endforeach; ?>
      <?php endif; ?>

      <!-- Static nav links -->
      <a href="#">New In Store</a>
      <a href="#">Brands</a>
      <a href="/contact.php">Contact</a>
      <a href="#">Drop Shipping</a>
      <a href="#">News</a>
      <a href="products.php">Products</a>
    </nav>

    <!-- Cart Dropdown -->
    <div class="cart-container">
      <button class="cart-btn">
        🛒 Cart (<span id="cart-count">0</span>)
      </button>
      <div class="cart-dropdown" id="cart-dropdown">
        <p>Your cart is empty</p>
        <ul id="cart-items"></ul>
        <div class="cart-total">
          Total: R<span id="cart-total">0.00</span>
        </div>
        <button id="checkout-btn">Checkout</button>
      </div>
    </div>

    <!-- Mobile menu icon -->
    <div class="mobile-menu-icon">☰</div>
  </div>
</header>
