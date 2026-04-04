<?php
session_start();
require '../public/partials/db.php';
include '../public/partials/header.php';

// Redirect guests
if (!isset($_SESSION['customer_id'])) {
    header("Location: ../login.php");
    exit;
}

$customerId = (int)$_SESSION['customer_id'];

// Fetch customer info
$stmt = $conn->prepare("SELECT full_name, email FROM customers WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $customerId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle form submission
$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);

    $stmt = $conn->prepare("UPDATE customers SET full_name = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $full_name, $email, $customerId);
    if ($stmt->execute()) {
        $success = true;
        $_SESSION['customer_name'] = $full_name; // update session if needed
    }
    $stmt->close();
}
?>

<div class="container">
    <h1>Account Settings</h1>

    <?php if ($success): ?>
        <p style="color:green;">Your information has been updated successfully.</p>
    <?php endif; ?>

    <form method="POST">
        <label>Full Name:</label><br>
        <input type="text" name="full_name" value="<?= htmlspecialchars($user['full_name']) ?>" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required><br><br>

        <button type="submit" class="primary-btn">Update Account</button>
    </form>
</div>

<?php include '../public/partials/footer.php'; ?>