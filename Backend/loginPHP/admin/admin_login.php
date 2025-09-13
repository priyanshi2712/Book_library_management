<?php
session_start();
require '../db_conn/config.php'; // Database connection

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get input values
    $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    if (!$email || !$password) {
        echo json_encode(["status" => 400, "message" => "All fields are required"]);
        exit;
    }

    // Check if admin exists
    $query = "SELECT * FROM admins WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $admin = mysqli_fetch_assoc($result);

        // Verify password
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_email'] = $admin['email'];

            echo json_encode([
                "status" => 200,
                "message" => "Login successful",
                "data" => [
                    "id" => $admin['id'],
                    "name" => $admin['name'],
                    "email" => $admin['email']
                ]
            ]);
        } else {
            echo json_encode(["status" => 401, "message" => "Invalid email or password"]);
        }
    } else {
        echo json_encode(["status" => 404, "message" => "Admin not found"]);
    }
} else {
    echo json_encode(["status" => 405, "message" => "Invalid request method"]);
}
