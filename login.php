<?php
session_start();
require 'public/partials/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, name, password FROM customers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($id, $name, $hash);
    $stmt->fetch();
    $stmt->close();

    if ($id && password_verify($password, $hash)) {

        session_regenerate_id(true);

        $_SESSION['customer_id'] = $id;
        $_SESSION['customer_name'] = $name;

        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid email or password";
    }
}
?>

<?php require 'public/partials/header.php'; ?>

<div class="container">
    <h1>Login</h1>

    <?php if(isset($error)): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit" class="primary-btn">Login</button>
    </form>

    <p>Don't have an account? <a href="register.php">Register here</a></p>
</div>

<?php require 'public/partials/footer.php'; ?>
