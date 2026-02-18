<?php
session_start();
require 'public/partials/db.php'; 
require 'public/partials/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id,name,password FROM customers WHERE email=?");
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $stmt->bind_result($id,$name,$hash);
    $stmt->fetch();

    if ($id && password_verify($password, $hash)) {
        $_SESSION['customer_id'] = $id;
        $_SESSION['customer_name'] = $name;
        header("Location: checkout.php");
        exit;
    } else {
        $error = "Invalid email or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login - ACE Online</title>
<link rel="stylesheet" href="public/assets/style.css">
</head>
<body>
<div class="container">
<h1>Login</h1>
<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="POST">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit" class="primary-btn">Login</button>
</form>
<p>Don't have an account? <a href="register.php">Register here</a></p>
</div>
</body>
</html>
