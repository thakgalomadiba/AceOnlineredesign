<?php
require 'public/partials/db.php';
include 'public/partials/header.php';

// Get product ID from URL, e.g., product.php?id=1
$productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($productId <= 0) {
    header("Location: index.php");
    exit;
}

// Fetch product with category and subcategory
$sqlProduct = "
SELECT 
    p.id,
    p.name,
    p.slug,
    p.description,
    p.price,
    p.stock_quantity,
    c.name AS category_name,
    s.name AS subcategory_name
FROM products p
LEFT JOIN categories c ON p.category_id = c.id
LEFT JOIN subcategories s ON p.subcategory_id = s.id
WHERE p.id = ? AND p.is_active = 1
LIMIT 1
";

$stmt = $conn->prepare($sqlProduct);
$stmt->bind_param("i", $productId);
$stmt->execute();
$productResult = $stmt->get_result();
$product = $productResult->fetch_assoc();

if (!$product) {
    header("Location: index.php");
    exit;
}

// Fetch all product images
$sqlImages = "SELECT image_path, is_primary FROM product_images WHERE product_id = ? ORDER BY sort_order ASC";
$stmtImages = $conn->prepare($sqlImages);
$stmtImages->bind_param("i", $productId);
$stmtImages->execute();
$imagesResult = $stmtImages->get_result();
$images = $imagesResult->fetch_all(MYSQLI_ASSOC);

// If no images, use default
if (empty($images)) {
    $images[] = ['image_path' => 'images/default.png', 'is_primary' => 1];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($product['name']); ?> - ACE Online</title>
  <link rel="stylesheet" href="public/assets/style.css">
</head>
<body>

<section class="product-detail">
  <div class="container">
    <div class="product-wrapper">

      <!-- Product Images -->
      <div class="product-image">
        <?php
        // Show primary image first
        $primaryImage = null;
        foreach ($images as $img) {
            if ($img['is_primary']) {
                $primaryImage = $img['image_path'];
                break;
            }
        }
        if (!$primaryImage) $primaryImage = $images[0]['image_path'];
        ?>
        <img src="public/uploads/products/<?php echo htmlspecialchars($primaryImage); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
        
        <!-- Thumbnails -->
        <?php if (count($images) > 1): ?>
        <div class="thumbnails">
            <?php foreach ($images as $img): ?>
                <img src="public/<?php echo htmlspecialchars($img['image_path']); ?>" alt="" class="thumb">
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>

      <!-- Product Info -->
      <div class="product-info">
        <h1><?php echo htmlspecialchars($product['name']); ?></h1>
        <p class="category">
            <?php 
            echo htmlspecialchars($product['category_name']);
            if ($product['subcategory_name']) echo " / " . htmlspecialchars($product['subcategory_name']); 
            ?>
        </p>
        <p class="price">R <?php echo number_format($product['price'], 2); ?></p>
        <p class="stock"><?php echo $product['stock_quantity'] > 0 ? 'In Stock' : 'Out of Stock'; ?></p>

        <p class="description">
          <?php echo nl2br(htmlspecialchars($product['description'])); ?>
        </p>

        <form method="POST" action="add_to_cart.php">
    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
    
    <button 
        type="submit"
        class="primary-btn add-to-cart"
        <?php echo $product['stock_quantity'] <= 0 ? 'disabled' : ''; ?>
    >
        Add to Cart
    </button>
</form>
        <br><br>

        <a href="javascript:history.back()" class="back-btn">← Back</a>
      </div>

    </div>
  </div>
</section>

<?php include 'public/partials/footer.php'; ?>
</body>
</html>