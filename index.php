<?php
require 'public/partials/db.php';
include 'public/partials/header.php';

// =========================
// FETCH CATEGORIES
// =========================
$categories = [];
$catSql = "SELECT id, name, slug, image_url FROM categories ORDER BY name ASC";
$catResult = $conn->query($catSql);

if ($catResult && $catResult->num_rows > 0) {
    while ($row = $catResult->fetch_assoc()) {
        $categories[] = $row;
    }
}

// =========================
// FETCH FEATURED PRODUCTS
// =========================
$featuredProducts = [];
$productSql = "
    SELECT 
        p.id,
        p.name,
        p.slug,
        p.price,
        p.brand,
        pi.image_path
    FROM products p
    LEFT JOIN product_images pi 
        ON p.id = pi.product_id AND pi.is_primary = 1
    WHERE p.is_featured = 1 
      AND p.is_active = 1
    ORDER BY p.created_at DESC
    LIMIT 6
";
$productResult = $conn->query($productSql);

if ($productResult && $productResult->num_rows > 0) {
    while ($row = $productResult->fetch_assoc()) {
        $featuredProducts[] = $row;
    }
}
?>

<!-- HERO SECTION -->
<section class="hero-banner">
  <div class="hero-text">
    <h1>Upgrade Your Tech Today</h1>
    <p>Premium Technology & Office Solutions</p>
    <a href="products.php" class="primary-btn">Shop Now</a>
  </div>
</section>

<!-- CATEGORY GRID -->
<section class="home-categories container">
  <div class="section-heading">
    <h2>Shop By Category</h2>
    <a href="products.php" class="view-all-link">Browse All</a>
  </div>

  <?php if (!empty($categories)): ?>
    <ul class="category-grid" id="category-list">
      <?php foreach ($categories as $category): ?>
        <li class="category-card">
          <a href="products.php?category=<?= urlencode($category['slug']) ?>">
            <img 
              src="<?= htmlspecialchars($category['image_url'] ?: 'uploads/categories/default.jpg') ?>" 
              alt="<?= htmlspecialchars($category['name']) ?>"
              loading="lazy"
              onerror="this.src='uploads/categories/default.jpg';"
            >
            <h3><?= htmlspecialchars($category['name']) ?></h3>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <div class="empty-state">
      <p>No categories available yet.</p>
    </div>
  <?php endif; ?>
</section>

<!-- FEATURED PRODUCTS -->
<section class="featured-products container">
  <div class="section-heading">
    <h2>Featured Products</h2>
    <a href="products.php" class="view-all-link">View All Products</a>
  </div>

  <?php if (!empty($featuredProducts)): ?>
    <div class="product-grid">
      <?php foreach ($featuredProducts as $product): ?>
        <div class="product-card">
          <a href="product-details.php?slug=<?= urlencode($product['slug']) ?>">
            <img 
              src="<?= htmlspecialchars($product['image_path'] ?: 'uploads/products/default.jpg') ?>" 
              alt="<?= htmlspecialchars($product['name']) ?>"
              loading="lazy"
              onerror="this.src='uploads/products/default.jpg';"
            >
            <div class="product-info">
              <h3><?= htmlspecialchars($product['name']) ?></h3>

              <?php if (!empty($product['brand'])): ?>
                <p class="product-brand"><?= htmlspecialchars($product['brand']) ?></p>
              <?php endif; ?>

              <p class="product-price"><strong>R<?= number_format((float)$product['price'], 2) ?></strong></p>
            </div>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="empty-state">
      <p>No featured products available yet.</p>
    </div>
  <?php endif; ?>
</section>

<!-- PROMO BANNER -->
<section class="promo-banner">
  <div class="promo-content">
    <h2>Big Savings This Week</h2>
    <p>Up to 30% off selected tech</p>
    <a href="products.php" class="secondary-btn">View Deals</a>
  </div>
</section>

<?php include 'public/partials/footer.php'; ?>