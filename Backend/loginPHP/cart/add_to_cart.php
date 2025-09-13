<?php
require '../db_conn/config.php';
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['user_id'], $data['book_id'], $data['quantity'])) {
        echo json_encode(["status" => "error", "message" => "All fields are required"]);
        exit;
    }

    $user_id = $data['user_id'];
    $book_id = $data['book_id'];
    $quantity = $data['quantity'];

    // Check if the book already exists in the cart
    $checkQuery = "SELECT * FROM cart WHERE user_id = '$user_id' AND book_id = '$book_id'";
    $result = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        // Update quantity
        $updateQuery = "UPDATE cart SET quantity = quantity + '$quantity' WHERE user_id = '$user_id' AND book_id = '$book_id'";
        mysqli_query($conn, $updateQuery);
    } else {
        // Insert new record
        $insertQuery = "INSERT INTO cart (user_id, book_id, quantity) VALUES ('$user_id', '$book_id', '$quantity')";
        mysqli_query($conn, $insertQuery);
    }

    echo json_encode(["status" => "success", "message" => "Book added to cart"]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
?>
