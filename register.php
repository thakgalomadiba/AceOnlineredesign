<?php
session_start();
require 'public/partials/db.php';
require 'public/partials/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $rawPassword = $_POST['password'];
    $password_hash = password_hash($rawPassword, PASSWORD_DEFAULT);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM customers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error = "Email already registered!";
    } else {
        // Insert customer into new schema
        $stmt = $conn->prepare("
            INSERT INTO customers (full_name, email, password_hash, phone)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->bind_param("ssss", $full_name, $email, $password_hash, $phone);

        if ($stmt->execute()) {
            $customer_id = $stmt->insert_id;

            // Insert address if provided
            if (!empty($address)) {
                $city = 'Johannesburg';
                $province = 'Gauteng';
                $postal_code = '';

                $addrStmt = $conn->prepare("
                    INSERT INTO addresses (customer_id, address_line1, city, province, postal_code, is_default)
                    VALUES (?, ?, ?, ?, ?, 1)
                ");
                $addrStmt->bind_param("issss", $customer_id, $address, $city, $province, $postal_code);
                $addrStmt->execute();
                $addrStmt->close();
            }

            $_SESSION['customer_id'] = $customer_id;
            $_SESSION['customer_name'] = $full_name;
            $_SESSION['customer_role'] = 'customer';

            header("Location: checkout.php");
            exit;
        } else {
            $error = "Registration failed. Try again!";
        }
    }

    $stmt->close();
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

<?php require 'public/partials/footer.php'; ?>