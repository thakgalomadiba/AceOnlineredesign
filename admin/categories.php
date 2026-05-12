<?php
session_start();

$base_url = '../';
require $base_url . 'public/partials/db.php';
include $base_url . 'public/partials/header.php';

// =========================
// HELPER: CREATE SLUG
// =========================
function createSlug($text) {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
}

// =========================
// HANDLE ADD MAIN CATEGORY
// =========================
if (isset($_POST['add_category'])) {
    $name = trim($_POST['name']);
    $slug = createSlug($name);

    if (!empty($name)) {
        $stmt = $conn->prepare("INSERT INTO categories (name, slug) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $slug);
        $stmt->execute();
        $stmt->close();

        header("Location: categories.php");
        exit;
    }
}

// =========================
// HANDLE ADD SUBCATEGORY
// =========================
if (isset($_POST['add_subcategory'])) {
    $name = trim($_POST['subcategory_name']);
    $category_id = intval($_POST['category_id']);
    $slug = createSlug($name);

    if (!empty($name) && $category_id > 0) {
        $stmt = $conn->prepare("INSERT INTO subcategories (category_id, name, slug) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $category_id, $name, $slug);
        $stmt->execute();
        $stmt->close();

        header("Location: categories.php");
        exit;
    }
}

// =========================
// HANDLE DELETE CATEGORY
// =========================
if (isset($_GET['delete_category'])) {
    $id = intval($_GET['delete_category']);

    // Delete subcategories first
    $stmt = $conn->prepare("DELETE FROM subcategories WHERE category_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    // Then delete category
    $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: categories.php");
    exit;
}

// =========================
// HANDLE DELETE SUBCATEGORY
// =========================
if (isset($_GET['delete_subcategory'])) {
    $id = intval($_GET['delete_subcategory']);

    $stmt = $conn->prepare("DELETE FROM subcategories WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: categories.php");
    exit;
}

// =========================
// FETCH CATEGORIES FOR FORMS
// =========================
$categoriesList = [];
$catResult = $conn->query("SELECT id, name, slug FROM categories ORDER BY name ASC");

if ($catResult && $catResult->num_rows > 0) {
    while ($row = $catResult->fetch_assoc()) {
        $categoriesList[] = $row;
    }
}

// =========================
// FETCH CATEGORIES + SUBCATEGORIES
// =========================
$sql = "
    SELECT 
        c.id AS category_id,
        c.name AS category_name,
        c.slug AS category_slug,
        s.id AS subcategory_id,
        s.name AS subcategory_name,
        s.slug AS subcategory_slug
    FROM categories c
    LEFT JOIN subcategories s ON c.id = s.category_id
    ORDER BY c.name ASC, s.name ASC
";
$results = $conn->query($sql);

// Group results
$groupedCategories = [];

if ($results && $results->num_rows > 0) {
    while ($row = $results->fetch_assoc()) {
        $catId = $row['category_id'];

        if (!isset($groupedCategories[$catId])) {
            $groupedCategories[$catId] = [
                'id' => $row['category_id'],
                'name' => $row['category_name'],
                'slug' => $row['category_slug'],
                'subcategories' => []
            ];
        }

        if (!empty($row['subcategory_id'])) {
            $groupedCategories[$catId]['subcategories'][] = [
                'id' => $row['subcategory_id'],
                'name' => $row['subcategory_name'],
                'slug' => $row['subcategory_slug']
            ];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Categories</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 20px;
        }

        .admin-card {
            background: #fff;
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
            margin-bottom: 30px;
        }

        h1, h2, h3 {
            margin-bottom: 20px;
        }

        form {
            display: grid;
            gap: 15px;
            max-width: 500px;
        }

        input, select, button {
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid #ddd;
            font-size: 1rem;
        }

        button {
            background: #0077cc;
            color: #fff;
            border: none;
            cursor: pointer;
            font-weight: 600;
        }

        button:hover {
            background: #005fa3;
        }

        .category-block {
            border: 1px solid #eee;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            background: #fafafa;
        }

        .category-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .slug {
            font-size: 0.9rem;
            color: #666;
        }

        .subcategory-list {
            margin-top: 10px;
            padding-left: 20px;
        }

        .subcategory-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        .subcategory-item:last-child {
            border-bottom: none;
        }

        .actions a {
            text-decoration: none;
            margin-left: 12px;
            font-weight: 600;
        }

        .delete {
            color: #d11a2a;
        }

        .edit {
            color: #0077cc;
        }

        .empty-note {
            color: #777;
            font-style: italic;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="admin-container">
    <h1>Categories Management</h1>

    <div class="admin-card">
        <h2>Add Main Category</h2>
        <form method="POST">
            <input type="text" name="name" placeholder="Main Category Name" required>
            <button type="submit" name="add_category">Add Category</button>
        </form>
    </div>

    <div class="admin-card">
        <h2>Add Subcategory</h2>
        <form method="POST">
            <input type="text" name="subcategory_name" placeholder="Subcategory Name" required>

            <select name="category_id" required>
                <option value="">-- Select Parent Category --</option>
                <?php foreach ($categoriesList as $category): ?>
                    <option value="<?= $category['id'] ?>">
                        <?= htmlspecialchars($category['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit" name="add_subcategory">Add Subcategory</button>
        </form>
    </div>

    <div class="admin-card">
        <h2>All Categories & Subcategories</h2>

        <?php if (!empty($groupedCategories)): ?>
            <?php foreach ($groupedCategories as $category): ?>
                <div class="category-block">
                    <div class="category-header">
                        <div>
                            <h3><?= htmlspecialchars($category['name']) ?></h3>
                            <div class="slug">Slug: <?= htmlspecialchars($category['slug']) ?></div>
                        </div>
                        <div class="actions">
                            <a class="edit" href="edit_category.php?id=<?= $category['id'] ?>">Edit</a>
                            <a class="delete" href="?delete_category=<?= $category['id'] ?>" onclick="return confirm('Delete this category and all its subcategories?')">Delete</a>
                        </div>
                    </div>

                    <?php if (!empty($category['subcategories'])): ?>
                        <div class="subcategory-list">
                            <?php foreach ($category['subcategories'] as $sub): ?>
                                <div class="subcategory-item">
                                    <div>
                                        <strong>↳ <?= htmlspecialchars($sub['name']) ?></strong><br>
                                        <span class="slug">Slug: <?= htmlspecialchars($sub['slug']) ?></span>
                                    </div>
                                    <div class="actions">
                                        <a class="edit" href="edit_subcategory.php?id=<?= $sub['id'] ?>">Edit</a>
                                        <a class="delete" href="?delete_subcategory=<?= $sub['id'] ?>" onclick="return confirm('Delete this subcategory?')">Delete</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="empty-note">No subcategories yet.</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No categories found yet.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>