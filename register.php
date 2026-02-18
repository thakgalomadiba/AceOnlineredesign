<?php
session_start();
require 'public/partials/db.php'; // DB connection
require 'public/partials/header.php'; // Include site header

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM customers WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error = "Email already registered!";
    } else {
        $stmt = $conn->prepare("INSERT INTO customers (name,email,password,phone,address) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss", $name, $email, $password, $phone, $address);
        if ($stmt->execute()) {
            $_SESSION['customer_id'] = $stmt->insert_id;
            $_SESSION['customer_name'] = $name;
            header("Location: checkout.php");
            exit;
        } else {
            $error = "Registration failed. Try again!";
        }
    }
}
?>
<!-- MAIN CONTENT -->
<div class="container" style="padding-top:20px;">
    <h1>Register</h1>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="name" placeholder="Full Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="text" name="phone" placeholder="Phone"><br>
        <textarea name="address" placeholder="Address"></textarea><br>
        <button type="submit" class="primary-btn">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</div>

<?php
// Include site footer if you have one
require 'public/partials/footer.php';
?>
