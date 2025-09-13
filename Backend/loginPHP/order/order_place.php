<?php
require '../db_conn/config.php';
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['user_id'], $data['books'], $data['total_price'])) {
        echo json_encode(["status" => "error", "message" => "User ID, books, and total price are required"]);
        exit;
    }

    $user_id = (int) $data['user_id'];
    $total_price = (float) $data['total_price'];

    // Insert order into 'orders' table
    $orderQuery = "INSERT INTO orders (user_id, total_price, status, created_at) VALUES ('$user_id', '$total_price', 'pending', NOW())";

    if (!mysqli_query($conn, $orderQuery)) {
        echo json_encode(["status" => "error", "message" => "Order insertion failed", "error" => mysqli_error($conn)]);
        exit;
    }

    $order_id = mysqli_insert_id($conn); // Get the inserted order ID

    // Insert order items
    foreach ($data['books'] as $book) {
        $book_id = (int) $book['book_id'];
        $quantity = (int) $book['quantity'];

        $itemQuery = "INSERT INTO order_items (order_id, book_id, quantity) VALUES ('$order_id', '$book_id', '$quantity')";
        if (!mysqli_query($conn, $itemQuery)) {
            echo json_encode(["status" => "error", "message" => "Failed to insert order item", "error" => mysqli_error($conn)]);
            exit;
        }
    }

    echo json_encode(["status" => "success", "message" => "Order placed successfully", "order_id" => $order_id]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}

mysqli_close($conn);
