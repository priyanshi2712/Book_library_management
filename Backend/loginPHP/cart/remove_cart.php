<?php
require '../db_conn/config.php';
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Read JSON input
    $data = json_decode(file_get_contents("php://input"), true);

    // Validate cart_id
    if (!isset($data['cart_id'])) {
        echo json_encode(["status" => "error", "message" => "Cart ID is required"]);
        exit;
    }

    $cart_id = $data['cart_id'];

    // Use prepared statements to prevent SQL injection
    $query = "DELETE FROM cart WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $cart_id);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo json_encode(["status" => "success", "message" => "Item removed from cart"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Cart item not found"]);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to prepare query"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
