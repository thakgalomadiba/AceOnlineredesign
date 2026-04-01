<?php
session_start();
require '../public/partials/db.php';

// =======================
// Handle Add Product
// =======================
if (isset($_POST['add_product'])) {
    $name = trim($_POST['name']);
    $desc = trim($_POST['description']);
    $price = trim($_POST['price']);
    $category_id = trim($_POST['category_id']);
    $image = '';

    // Handle file upload
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
        $uploads_dir = '../uploads/';
        if(!is_dir($uploads_dir)) {
            mkdir($uploads_dir, 0777, true);
        }
        $image = $uploads_dir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    $stmt = $conn->prepare("INSERT INTO products (name, description, price, category_id, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdiss", $name, $desc, $price, $category_id, $image);
    $stmt->execute();

    header("Location: products.php"); // Refresh page to show new product
    exit;
}

// =======================
// Handle Delete Product
// =======================
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM products WHERE id = $id");
    header("Location: products.php"); // Refresh page after deletion
    exit;
}

// =======================
// Fetch products
// =======================
$products = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Products</title>
    
</head>
<body>
<h1>Products Management</h1>

<!-- Add Product Form -->
<h2>Add Product</h2>
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Product Name" required><br>
    <textarea name="description" placeholder="Description"></textarea><br>
    <input type="number" step="0.01" name="price" placeholder="Price" required><br>
    <input type="number" name="category_id" placeholder="Category ID" required><br>
    <input type="file" name="image"><br>
    <button type="submit" name="add_product">Add Product</button>
</form>

<!-- Products Table -->
<h2>All Products</h2>
<table border="1">
    <tr>
        <th>ID</th><th>Name</th><th>Price</th><th>Category</th><th>Image</th><th>Actions</th>
    </tr>
    <?php while($row = $products->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= $row['price'] ?></td>
        <td><?= $row['category_id'] ?></td>
        <td>
            <?php if($row['image'] && file_exists('../' . $row['image'])): ?>
                <img src="../<?= $row['image'] ?>" width="50">
            <?php endif; ?>
        </td>
        <td>
            <a href="edit_product.php?id=<?= $row['id'] ?>">Edit</a> |
            <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this product?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
</body>
</html>