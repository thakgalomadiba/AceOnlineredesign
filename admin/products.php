<?php
session_start();
$base_url = '../'; 
require $base_url . 'public/partials/db.php';
include $base_url . 'public/partials/header.php';

// =======================
// Handle Add Product
// =======================
if (isset($_POST['add_product'])) {
    $name = trim($_POST['name']);
    $slug = trim($_POST['slug']);
    $desc = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $stock_quantity = intval($_POST['stock_quantity']);
    $category_id = intval($_POST['category_id']);
    $subcategory_id = !empty($_POST['subcategory_id']) ? intval($_POST['subcategory_id']) : null;
    $brand = trim($_POST['brand']);
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;

    // Insert product
    $stmt = $conn->prepare("
        INSERT INTO products 
        (category_id, subcategory_id, name, slug, description, price, stock_quantity, brand, is_active, is_featured) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("iisssdiiii", $category_id, $subcategory_id, $name, $slug, $desc, $price, $stock_quantity, $brand, $is_active, $is_featured);
    $stmt->execute();
    $productId = $stmt->insert_id;

    // Handle multiple images
    if (!empty($_FILES['images']['name'][0])) {
        $uploadDir = '../public/uploads/products/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
            $filename = time() . '_' . basename($_FILES['images']['name'][$index]);
            $targetFile = $uploadDir . $filename;
            if (move_uploaded_file($tmpName, $targetFile)) {
                $isPrimary = ($index === 0) ? 1 : 0;
                $stmtImg = $conn->prepare("
                    INSERT INTO product_images (product_id, image_path, is_primary) VALUES (?, ?, ?)
                ");
                $stmtImg->bind_param("isi", $productId, $filename, $isPrimary);
                $stmtImg->execute();
            }
        }
    }

    header("Location: products.php");
    exit;
}

// =======================
// Handle Delete Product
// =======================
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM products WHERE id = $id");
    header("Location: products.php");
    exit;
}

// =======================
// Fetch products with category/subcategory names
// =======================
$products = $conn->query("
    SELECT p.*, c.name AS category_name, s.name AS subcategory_name 
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    LEFT JOIN subcategories s ON p.subcategory_id = s.id
    ORDER BY p.id DESC
");

// Fetch categories for dropdown
$categories = $conn->query("SELECT * FROM categories ORDER BY name ASC");
?>

<div class="container">
    <h1>Products Management</h1>

    <!-- Add Product Form -->
    <h2>Add Product</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Product Name" required><br>
        <input type="text" name="slug" placeholder="Slug (unique)" required><br>

        <select name="category_id" id="categorySelect" required>
            <option value="">Select Category</option>
            <?php while($cat = $categories->fetch_assoc()): ?>
                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
            <?php endwhile; ?>
        </select><br>

        <select name="subcategory_id" id="subcategorySelect">
            <option value="">Select Subcategory</option>
            <!-- Optional: load dynamically via JS/AJAX -->
        </select><br>

        <input type="number" step="0.01" name="price" placeholder="Price" required><br>
        <input type="number" name="stock_quantity" placeholder="Stock Quantity" required><br>
        <input type="text" name="brand" placeholder="Brand"><br>
        <textarea name="description" placeholder="Description"></textarea><br>

        <label>Product Images:</label>
        <input type="file" name="images[]" multiple><br>

        <label><input type="checkbox" name="is_active" checked> Active</label>
        <label><input type="checkbox" name="is_featured"> Featured</label><br>

        <button type="submit" name="add_product">Add Product</button>
    </form>

    <!-- Products Table -->
    <h2>All Products</h2>
    <table border="1">
        <tr>
            <th>ID</th><th>Name</th><th>Price</th><th>Category</th><th>Subcategory</th><th>Stock</th><th>Actions</th>
        </tr>
        <?php while($row = $products->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td>R <?= number_format($row['price'], 2) ?></td>
            <td><?= htmlspecialchars($row['category_name']) ?></td>
            <td><?= htmlspecialchars($row['subcategory_name']) ?></td>
            <td><?= $row['stock_quantity'] ?></td>
            <td>
                <a href="edit_product.php?id=<?= $row['id'] ?>">Edit</a> |
                <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this product?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>