<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
$isLoggedIn = isset($_SESSION['customer_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ACE Online SA</title>

<link rel="stylesheet" href="/public/assets/css/base.css">
<link rel="stylesheet" href="/public/assets/css/layout.css">
<link rel="stylesheet" href="/public/assets/css/components/header.css">
<link rel="stylesheet" href="/public/assets/css/components/footer.css">
<link rel="stylesheet" href="/public/assets/css/components/buttons.css">
<link rel="stylesheet" href="/public/assets/css/components/cards.css">
<link rel="stylesheet" href="/public/assets/css/components/dropdown.css">
<link rel="stylesheet" href="/public/assets/css/pages/products.css">


<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

<!-- ================= TOP BAR ================= -->
<div class="top-bar">
    <div class="container">
        <div>Fast Delivery Across South Africa 🇿🇦</div>
        <div class="top-links">
            <a href="/contact.php">Contact</a>
            <a href="/about.php">About</a>
        </div>
    </div>
</div>

<!-- ================= MAIN HEADER ================= -->
<header class="main-header">
    <div class="container main-nav">

        <!-- Logo -->
        <div class="logo">
            <a href="/index.php">ACE ONLINE</a>
        </div>

        <!-- Search -->
        <form action="/products.php" method="GET" class="search-bar">
            <input type="text" name="search" placeholder="Search for products..." />
            <button type="submit">Search</button>
        </form>

        <!-- Navigation + Actions -->
        <div class="nav-actions">

            <div class="nav-links">
                <a href="/index.php">Home</a>
                <a href="/products.php">Shop</a>
            </div>

            <!-- Account -->
            <div class="account-dropdown">
                <div class="account-btn">
                    <?php if($isLoggedIn): ?>
                        Hi, <?php echo htmlspecialchars($_SESSION['customer_name']); ?>
                    <?php else: ?>
                        Account
                    <?php endif; ?>
                </div>

                <div class="dropdown-menu">
                    <?php if($isLoggedIn): ?>
                        <a href="/account/dashboard.php">Dashboard</a>
                        <a href="/account/orders.php">My Orders</a>
                        <a href="/account/settings.php">Settings</a>
                        <a href="/logout.php">Logout</a>
                    <?php else: ?>
                        <a href="/login.php">Login</a>
                        <a href="/register.php">Register</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Cart -->
            <div class="cart-container">
                <div class="cart-btn">
                    🛒 Cart
                    <?php if($cartCount > 0): ?>
                        <span class="cart-count"><?php echo $cartCount; ?></span>
                    <?php endif; ?>
                </div>

                <div class="dropdown-menu">
                    <a href="/cart.php">View Cart</a>
                    <a href="/checkout.php">Checkout</a>
                </div>
            </div>

        </div>
    </div>
</header>
