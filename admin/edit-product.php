<?php
session_start();
require '../public/partials/db.php';

$id = intval($_GET['id']);
$product = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();

if(isset($_POST['update_product'])){
    $name = trim($_POST['name']);
    $desc = trim($_POST['description']);
    $price = trim($_POST['price']);
    $category_id = trim($_POST['category_id']);
    $image = $product['image'];

    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
        $image = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, category_id=?, image=? WHERE id=?");
    $stmt->bind_param("ssdisi", $name, $desc, $price, $category_id, $image, $id);
    $stmt->execute();
    header("Location: products.php");
}
?>

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required><br>
    <textarea name="description"><?= htmlspecialchars($product['description']) ?></textarea><br>
    <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required><br>
    <input type="number" name="category_id" value="<?= $product['category_id'] ?>" required><br>
    <input type="file" name="image"><br>
    <img src="<?= $product['image'] ?>" width="100"><br>
    <button type="submit" name="update_product">Update Product</button>
</form>