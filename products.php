<?php
require 'public/partials/db.php';

// Pagination settings
$perPageOptions = [5, 10, 20, 50];
$perPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
if (!in_array($perPage, $perPageOptions)) $perPage = 10;

// Current page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Count total active products
$countQuery = "SELECT COUNT(*) AS total FROM products WHERE is_active = 1";
$countResult = $conn->query($countQuery);

if (!$countResult) {
    die("Count query failed: " . $conn->error);
}

$totalProducts = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalProducts / $perPage);

if ($totalPages < 1) $totalPages = 1;
if ($page > $totalPages) $page = $totalPages;

$start = ($page - 1) * $perPage;

// Fetch products
$sql = "
SELECT 
    p.id,
    p.name,
    p.slug,
    p.price,
    p.stock_quantity,
    c.name AS category_name,
    s.name AS subcategory_name,
    pi.image_path AS primary_image
FROM products p
LEFT JOIN categories c ON p.category_id = c.id
LEFT JOIN subcategories s ON p.subcategory_id = s.id
LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.is_primary = 1
WHERE p.is_active = 1
ORDER BY p.created_at DESC
LIMIT $start, $perPage
";

$result = $conn->query($sql);

if (!$result) {
    die("Products query failed: " . $conn->error);
}

$products = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products - ACE Online</title>
  <link rel="stylesheet" href="public/assets/style.css">
</head>
<body>

<?php include 'public/partials/header.php'; ?>

<section class="product-list">
  <div class="container">
    <h1>Products</h1>

    <!-- Products per page dropdown -->
    <form method="GET" id="perPageForm">
      <label for="per_page">Show:</label>
      <select name="per_page" id="per_page" onchange="document.getElementById('perPageForm').submit()">
        <?php foreach ($perPageOptions as $opt): ?>
          <option value="<?php echo $opt; ?>" <?php echo $perPage == $opt ? 'selected' : ''; ?>>
            <?php echo $opt; ?>
          </option>
        <?php endforeach; ?>
      </select> products per page
    </form>

    <div class="products-grid">
      <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
          <div class="product-card">
            <a href="product.php?id=<?php echo $product['id']; ?>">
              <img 
                src="public/uploads/products/<?php echo !empty($product['primary_image']) ? htmlspecialchars($product['primary_image']) : 'default.png'; ?>" 
                alt="<?php echo htmlspecialchars($product['name']); ?>"
              >
              <h2><?php echo htmlspecialchars($product['name']); ?></h2>
              <p>
                <?php echo htmlspecialchars($product['category_name']); ?>
                <?php if (!empty($product['subcategory_name'])): ?>
                  / <?php echo htmlspecialchars($product['subcategory_name']); ?>
                <?php endif; ?>
              </p>
              <p>R <?php echo number_format($product['price'], 2); ?></p>
            </a>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No products found.</p>
      <?php endif; ?>
    </div>

    <!-- Pagination -->
    <div class="pagination">
      <?php if ($page > 1): ?>
        <a href="?page=<?php echo $page - 1; ?>&per_page=<?php echo $perPage; ?>">&laquo; Previous</a>
      <?php endif; ?>

      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?php echo $i; ?>&per_page=<?php echo $perPage; ?>" 
           class="<?php echo $page == $i ? 'active' : ''; ?>">
           <?php echo $i; ?>
        </a>
      <?php endfor; ?>

      <?php if ($page < $totalPages): ?>
        <a href="?page=<?php echo $page + 1; ?>&per_page=<?php echo $perPage; ?>">Next &raquo;</a>
      <?php endif; ?>
    </div>

  </div>
</section>

<?php include 'public/partials/footer.php'; ?>
</body>
</html>