<?php
// require '../db_conn/config.php';
// header("Content-Type: application/json");

// $query = "SELECT * FROM books";
// $result = mysqli_query($conn, $query);
// $books = [];

// while ($row = mysqli_fetch_assoc($result)) {
//     $books[] = $row;
// }

// echo json_encode([
//     "status" => 200,
//     "message" => "Books fetched successfully",
//     "data" => $books
// ]);

//===============================================================>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

require '../db_conn/config.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($conn) || !$conn) {
    die(json_encode(["error" => "Database connection failed: " . mysqli_connect_error()]));
}

// Base URL for images
$base_url = "http://127.0.0.1/loginphp/uploads/";

$query = "SELECT * FROM books";
$result = mysqli_query($conn, $query);

// Fetch books
$books = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        
        $row['image_url'] = !empty($row['image_url']) ? $base_url . basename($row['image_url']) : null;
        $books[] = $row;
    }
    echo json_encode(["data" => $books]);
} else {
    echo json_encode(["error" => "Failed to fetch books: " . mysqli_error($conn)]);
}

mysqli_close($conn);
