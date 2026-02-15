<?php
// Load products from JSON
$productsFile = 'products.json';
$products = [];
if (file_exists($productsFile)) {
    $products = json_decode(file_get_contents($productsFile), true);
}

// Pagination settings
$perPageOptions = [5, 10, 20, 50]; // dropdown options
$perPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
if (!in_array($perPage, $perPageOptions)) $perPage = 10;

$totalProducts = count($products);
$totalPages = ceil($totalProducts / $perPage);

// Current page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
if ($page > $totalPages) $page = $totalPages;

// Slice products array for current page
$start = ($page - 1) * $perPage;
$paginatedProducts = array_slice($products, $start, $perPage);
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
      <?php foreach ($paginatedProducts as $product): ?>
        <div class="product-card">
          <a href="product.php?id=<?php echo $product['id']; ?>">
            <img src="public/<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            <h2><?php echo $product['name']; ?></h2>
            <p>R <?php echo number_format($product['price'], 2); ?></p>
          </a>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <div class="pagination">
      <?php if ($page > 1): ?>
        <a href="?page=<?php echo $page - 1; ?>&per_page=<?php echo $perPage; ?>">&laquo; Previous</a>
      <?php endif; ?>

      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?php echo $i; ?>&per_page=<?php echo $perPage; ?>" 
           class="<?php echo $page == $i ? 'active' : ''; ?>"><?php echo $i; ?></a>
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
