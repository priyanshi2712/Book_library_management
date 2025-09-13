<?php
require '../db_conn/config.php';
header("Content-Type: application/json");

$query = "SELECT * FROM orders ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);

$orders = [];
while ($row = mysqli_fetch_assoc($result)) {
    $orders[] = $row;
}

echo json_encode(["status" => "success", "orders" => $orders]);
mysqli_close($conn);
?>
