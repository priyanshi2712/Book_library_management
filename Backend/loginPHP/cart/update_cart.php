<?php
require '../db_conn/config.php';
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Get JSON data from request body
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['cart_id']) || !isset($data['quantity'])) {
        echo json_encode(["status" => "error", "message" => "Cart ID and quantity are required"]);
        exit;
    }

    $cart_id = mysqli_real_escape_string($conn, $data['cart_id']);
    $quantity = mysqli_real_escape_string($conn, $data['quantity']);

    // Check if the cart item exists
    $checkQuery = "SELECT * FROM cart WHERE id = '$cart_id'";
    $result = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        // Update the cart quantity
        $updateQuery = "UPDATE cart SET quantity = '$quantity' WHERE id = '$cart_id'";
        if (mysqli_query($conn, $updateQuery)) {
            echo json_encode(["status" => "success", "message" => "Cart updated successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update cart"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Cart item not found"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}

mysqli_close($conn);
