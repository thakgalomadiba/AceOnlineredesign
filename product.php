<?php
// Load products from JSON
$productsFile = 'products.json';
$products = [];
if (file_exists($productsFile)) {
    $products = json_decode(file_get_contents($productsFile), true);
}

// Get product ID from URL, e.g., product.php?id=1
$productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$product = null;

foreach ($products as $p) {
    if ($p['id'] === $productId) {
        $product = $p;
        break;
    }
}

// Redirect if product not found
if (!$product) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $product['name']; ?> - ACE Online</title>
  <link rel="stylesheet" href="public/assets/style.css">
</head>
<body>

<?php include 'public/partials/header.php'; ?>

<!-- PRODUCT DETAIL SECTION -->
<section class="product-detail">
  <div class="container">
    <div class="product-wrapper">

      <!-- Product Image -->
      <div class="product-image">
       <img src="public/<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">

      </div>

      <!-- Product Info -->
      <div class="product-info">
        <h1><?php echo $product['name']; ?></h1>
        <p class="category"><?php echo $product['category'] . " / " . $product['subcategory']; ?></p>
        <p class="price">R <?php echo number_format($product['price'], 2); ?></p>
        <p class="description">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus fermentum nisi at est vehicula, at sagittis justo gravida.
        </p>

        <button class="primary-btn add-to-cart" data-id="<?php echo $product['id']; ?>">Add to Cart</button>
        <br><br>
        <a href="categories.php" class="back-btn">← Back to Categories</a>
      </div>

    </div>
  </div>
</section>

<?php include 'public/partials/footer.php'; ?>
</body>
</html>
