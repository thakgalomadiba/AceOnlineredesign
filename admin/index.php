<?php
session_start();
$base_url = '../'; // relative path from admin folder to project root
require $base_url . 'public/partials/db.php';
include $base_url . 'public/partials/header.php';
?>

<!-- HERO SECTION -->
<section class="hero-banner">
  <div class="hero-text">
    <h1>Welcome, Admin</h1>
    <p>Manage Your Products and Categories</p>
    <a href="products.php" class="primary-btn">Manage Products</a>
  </div>
</section>

<!-- ADMIN QUICK LINKS / DASHBOARD CARDS -->
<section class="admin-dashboard container">
  <h2>Quick Access</h2>
  <div class="dashboard-cards">
    <div class="card">
      <h3>Products</h3>
      <p>View, Add, Edit, Delete Products</p>
      <a href="products.php" class="secondary-btn">Go</a>
    </div>
    <div class="card">
      <h3>Categories</h3>
      <p>Manage Product Categories</p>
      <a href="categories.php" class="secondary-btn">Go</a>
    </div>
    <div class="card">
      <h3>Orders</h3>
      <p>View Customer Orders</p>
      <a href="orders.php" class="secondary-btn">Go</a>
    </div>
  </div>
</section>

<?php include '../public/partials/footer.php'; ?>