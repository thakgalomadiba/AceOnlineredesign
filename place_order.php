<?php
session_start();
require 'db.php';

if(!isset($_SESSION['customer_id'])) {
    echo json_encode(['status'=>'error','message'=>'Not logged in']);
    exit;
}

// Get cart from POST (we can send from checkout.js)
$data = json_decode(file_get_contents("php://input"), true);
$cart = $data['cart'] ?? [];

if(empty($cart)) {
    echo json_encode(['status'=>'error','message'=>'Cart is empty']);
    exit;
}

$total = 0;
foreach($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}

// Insert order
$stmt = $conn->prepare("INSERT INTO orders (customer_id,total_price) VALUES (?,?)");
$stmt->bind_param("id", $_SESSION['customer_id'],$total);
$stmt->execute();
$order_id = $stmt->insert_id;

// Insert order items
$stmt_item = $conn->prepare("INSERT INTO order_items (order_id,product_id,quantity,price) VALUES (?,?,?,?)");
foreach($cart as $item){
    $stmt_item->bind_param("iiid", $order_id, $item['id'], $item['quantity'], $item['price']);
    $stmt_item->execute();
}

echo json_encode(['status'=>'success','message'=>'Order placed successfully']);
