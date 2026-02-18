<?php
// header.php
// session_start() should already be called on the main page
?>
<header class="main-header">
  <link rel="stylesheet" href="public/assets/style.css">
  <div class="container header-content">

    <!-- Logo -->
    <div class="logo">
      <a href="/index.php">ACE ONLINE SA</a>
    </div>

    <!-- Navigation -->
    <nav class="main-nav">
      <a href="/index.php">Home</a>
      <a href="/products.php">Products</a>

      <!-- Check if customer is logged in -->
      <?php if(isset($_SESSION['customer_name'])): ?>
        <div class="nav-user">
          <span>Welcome, <?php echo htmlspecialchars($_SESSION['customer_name']); ?>!</span>
          <a href="/logout.php" class="logout-btn">Logout</a>
        </div>
      <?php else: ?>
        <a href="/login.php">Login</a>
        <a href="/register.php">Register</a>
      <?php endif; ?>
    </nav>

    <!-- Cart -->
    <div class="cart-container">
      <button class="cart-btn">🛒 Cart (<span id="cart-count">0</span>)</button>
      <div class="cart-dropdown" id="cart-dropdown">
        <ul id="cart-items"></ul>
        <div class="cart-total">
          Total: R<span id="cart-total">0.00</span>
        </div>
        <a href="/checkout.php" id="checkout-btn" class="primary-btn">Checkout</a>
      </div>
    </div>

    <!-- Mobile menu icon -->
    <div class="mobile-menu-icon">☰</div>
  </div>
</header>
