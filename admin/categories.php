<?php
session_start();

$base_url = '../'; // relative path from admin folder to project root
require $base_url . 'public/partials/db.php';
include $base_url . 'public/partials/header.php';

// Handle Add Category
if (isset($_POST['add_category'])) {
    $name = trim($_POST['name']);
    $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
    $stmt->bind_param("s", $name);
    $stmt->execute();
}

// Handle Delete Category
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM categories WHERE id = $id");
}

// Fetch categories
$categories = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Categories</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Categories Management</h1>

<h2>Add Category</h2>
<form method="POST">
    <input type="text" name="name" placeholder="Category Name" required>
    <button type="submit" name="add_category">Add Category</button>
</form>

<h2>All Categories</h2>
<table border="1">
    <tr>
        <th>ID</th><th>Name</th><th>Actions</th>
    </tr>
    <?php while($row = $categories->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td>
            <a href="edit_category.php?id=<?= $row['id'] ?>">Edit</a> |
            <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this category?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
</body>
</html>