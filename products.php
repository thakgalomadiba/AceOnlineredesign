<?php include 'public/partials/header.php'; ?>

<?php
$productsFile = 'products.json';
$products = [];

if (file_exists($productsFile)) {
    $products = json_decode(file_get_contents($productsFile), true);
}
?>

<section class="products-page">
  <div class="container">

    <h1 class="page-title">Our Products</h1>

    <div class="products-grid">

      <?php if (!empty($products)): ?>

        <?php foreach ($products as $product): ?>
          
          <div class="product-card">
            
            <div class="product-image">
              <img src="public/<?php echo $product['image']; ?>" 
                   alt="<?php echo htmlspecialchars($product['name']); ?>">
            </div>

            <div class="product-info">
              <h3><?php echo htmlspecialchars($product['name']); ?></h3>
              <p class="price">R <?php echo number_format($product['price'], 2); ?></p>
              
              <!-- Link to individual product page -->
              <a href="product.php?id=<?php echo $product['id']; ?>" class="primary-btn">
                View Product
              </a>
            </div>

          </div>

        <?php endforeach; ?>

      <?php else: ?>
        <p>No products found.</p>
      <?php endif; ?>

    </div>
  </div>
</section>

<?php include 'public/partials/footer.php'; ?>
