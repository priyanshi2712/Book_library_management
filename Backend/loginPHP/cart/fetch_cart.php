<?php
require '../db_conn/config.php';
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['user_id'])) {
        echo json_encode(["status" => "error", "message" => "User ID is required"]);
        exit;
    }

    $user_id = $_GET['user_id'];
    $query = "SELECT cart.id, books.title, books.price, cart.quantity, (books.price * cart.quantity) AS total_price 
              FROM cart 
              JOIN books ON cart.book_id = books.id 
              WHERE cart.user_id = '$user_id'";

    $result = mysqli_query($conn, $query);
    $cartItems = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $cartItems[] = $row;
    }

    echo json_encode(["status" => "success", "cart" => $cartItems]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
