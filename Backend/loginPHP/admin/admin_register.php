<?php
session_start();
require '../db_conn/config.php'; // Database connection

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if keys exist before accessing them
    $name = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : null;
    $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : null;
    $password = isset($_POST['password']) ? mysqli_real_escape_string($conn, $_POST['password']) : null;

    if (!$name || !$email || !$password) {
        echo json_encode(["status" => "error", "message" => "All fields are required"]);
        exit;
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Check if email already exists
    $checkEmail = "SELECT id FROM admins WHERE email = '$email'";
    $result = mysqli_query($conn, $checkEmail);
    if (mysqli_num_rows($result) > 0) {
        echo json_encode(["status" => "error", "message" => "Email already registered"]);
        exit;
    }

    // Insert new admin
    $query = "INSERT INTO admins (name, email, password) VALUES ('$name', '$email', '$hashedPassword')";
    if (mysqli_query($conn, $query)) {
        echo json_encode(["status" => "success", "message" => "Admin registered successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Registration failed"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
