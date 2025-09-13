<?php
require '../db_conn/config.php';
header("Content-Type: application/json");

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(["status" => "error", "message" => "Order ID is required"]);
    exit;
}

$order_id = mysqli_real_escape_string($conn, $_GET['id']);

// Fetch order details
$orderQuery = "SELECT * FROM orders WHERE id = '$order_id'";
$orderResult = mysqli_query($conn, $orderQuery);

if (!$orderResult) {
    echo json_encode(["status" => "error", "message" => "Database error: " . mysqli_error($conn)]);
    exit;
}

$order = mysqli_fetch_assoc($orderResult);

if (!$order) {
    echo json_encode(["status" => "error", "message" => "Order not found"]);
    exit;
}

// Fetch order items
$itemQuery = "SELECT books.title, order_items.quantity FROM order_items 
              JOIN books ON order_items.book_id = books.id 
              WHERE order_items.order_id = '$order_id'";

$itemResult = mysqli_query($conn, $itemQuery);

if (!$itemResult) {
    echo json_encode(["status" => "error", "message" => "Database error: " . mysqli_error($conn)]);
    exit;
}

$items = [];
while ($row = mysqli_fetch_assoc($itemResult)) {
    $items[] = $row;
}

$order['items'] = $items;
echo json_encode(["status" => "success", "order" => $order]);

mysqli_close($conn);
