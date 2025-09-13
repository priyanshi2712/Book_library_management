<?php
require '../db_conn/config.php';
header("Content-Type: application/json");

if (!isset($_GET['id'])) {
    echo json_encode(["status" => "error", "message" => "Book ID is required"]);
    exit;
}

$id = $_GET['id'];
$query = "SELECT * FROM books WHERE id='$id'";
$result = mysqli_query($conn, $query);

if ($row = mysqli_fetch_assoc($result)) {
    echo json_encode([
        "status" => 200,
        "message" => "Book fetched successfully",
        "data" => $row
    ]);
} else {
    echo json_encode(["status" => "error", "message" => "Book not found"]);
}
