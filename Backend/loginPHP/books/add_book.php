<?php
session_start();
require '../db_conn/config.php';
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['title'], $data['price'], $data['description'], $data['author_name'], $data['stock'])) {
        echo json_encode(["status" => "error", "message" => "All fields are required"]);
        exit;
    }

    $title = mysqli_real_escape_string($conn, $data['title']);
    $price = $data['price'];
    $description = mysqli_real_escape_string($conn, $data['description']);
    $author_name = mysqli_real_escape_string($conn, $data['author_name']);
    $stock = $data['stock'];

    $query = "INSERT INTO books (title, price, description, author_name, stock) VALUES ('$title', '$price', '$description', '$author_name', '$stock')";

    if (mysqli_query($conn, $query)) {
        echo json_encode(["status" => "success", "message" => "Book added successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to add book"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
