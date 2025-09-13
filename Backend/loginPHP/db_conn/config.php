<?php
/*
This file contains database configuration assuming you are running mysql using user "root" and password ""
*/
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'librotech');

// Try connecting to the Database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

//Check the connection
// if ($conn == false) {
if (!$conn) {
    // die('Error: Cannot connect');
    // die('Error: Cannot connect to database. ' . mysqli_connect_error());
    die(json_encode(["status" => "error", "message" => "Database connection failed: " . mysqli_connect_error()]));
}
        