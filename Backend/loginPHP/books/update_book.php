<?php
require '../db_conn/config.php';
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);

    // Use $data['id'] instead of $_GET['id']
    if (!isset($data['id'], $data['title'], $data['price'], $data['description'], $data['author_name'], $data['stock'])) {
        echo json_encode(["status" => "error", "message" => "All fields are required"]);
        exit;
    }

    $id = $data['id']; // Extract ID from JSON body
    $title = mysqli_real_escape_string($conn, $data['title']);
    $price = $data['price'];
    $description = mysqli_real_escape_string($conn, $data['description']);
    $author_name = mysqli_real_escape_string($conn, $data['author_name']);
    $stock = $data['stock'];

    $query = "UPDATE books SET title='$title', price='$price', description='$description', author_name='$author_name', stock='$stock' WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        echo json_encode(["status" => "success", "message" => "Book updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update book"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
