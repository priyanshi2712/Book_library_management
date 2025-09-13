<?php
require '../db_conn/config.php';
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);

    // Check if 'id' is present in the JSON body
    if (!isset($data['id'])) {
        echo json_encode(["status" => "error", "message" => "Book ID is required"]);
        exit;
    }

    $id = $data['id'];

    // Delete query
    $query = "DELETE FROM books WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        echo json_encode(["status" => "success", "message" => "Book deleted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to delete book"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
