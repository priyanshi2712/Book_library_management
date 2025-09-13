<?php
require '../db_conn/config.php';
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Get the raw POST data and decode it
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['order_id'])) {
        echo json_encode(["status" => "error", "message" => "Order ID is required"]);
        exit;
    }

    $order_id = mysqli_real_escape_string($conn, $data['order_id']);

    // Check if order exists
    $checkQuery = "SELECT * FROM orders WHERE id = '$order_id'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Update order status to 'canceled'
        $updateQuery = "UPDATE orders SET status = 'canceled' WHERE id = '$order_id'";
        if (mysqli_query($conn, $updateQuery)) {
            echo json_encode(["status" => "success", "message" => "Order canceled successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to cancel order"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Order not found"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}

mysqli_close($conn);
