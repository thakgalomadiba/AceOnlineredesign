<?php include 'public/partials/header.php'; ?>

<!-- SEARCH BAR -->
<section class="search-section">
  <div class="container search-container">
    <div class="category-btn">ALL CATEGORIES ☰</div>
    <div class="search-box">
      <input type="text" placeholder="Search products" id="product-search">
      <button class="search-btn">🔍</button>
    </div>
  </div>
</section>

<!-- MAIN LAYOUT -->
<div class="container layout">

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <h3>All Categories</h3>
    <div id="category-list" class="category-grid">
      <!-- Categories loaded dynamically with JS -->
  </div>
  </aside>

  <!-- PRODUCTS GRID -->
  <main class="products-grid">
    <div id="product-list" class="grid-container">
      <!-- Products loaded dynamically with JS -->
    </div>
  </main>

</div>

<?php include 'public/partials/footer.php'; ?>
