<?php include 'public/partials/header.php'; ?>


<!-- SEARCH BAR -->
<section class="search-section">
  <div class="container search-container">
    <div class="category-btn">ALL CATEGORIES ☰</div>
    <div class="search-box">
      <input type="text" placeholder="Search store">
      <button class="search-btn">🔍</button>
    </div>
  </div>
</section>

<!-- MAIN LAYOUT -->
<div class="container layout">

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <h3>All Categories</h3>
    <ul id="category-list">
      <!-- Categories loaded dynamically with JS -->
    </ul>
  </aside>

  <!-- HERO SECTION -->
  <main class="hero">
    <div class="hero-content">
      <h1>Best Every Time</h1>
      <p>Technology & Office Solutions</p>
      <button class="primary-btn">Shop Now</button>
    </div>
  </main>

</div>

<?php include 'public/partials/footer.php'; ?>
