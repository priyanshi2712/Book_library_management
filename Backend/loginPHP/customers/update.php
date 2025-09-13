<?php
error_reporting(0);

header('Access-control-Allow-Origin:*');
header('Control-Type:application/json');
header('Access-Control-Allow-Method: PUT');
header('Access-Control-Allow-Header: Content-Type,Access-Control-Allow-Header,Authorization,x-Request-With');

include('function.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];
if ($requestMethod == 'PUT') {
    $inputData = json_decode(file_get_contents("php://input"), true);
    // if (empty($inputData)) {
    //     $updateCustomer = updateCustomer($_POST, $_GET);
    // } else {
    $updateCustomer = updateCustomer($inputData, $_GET);
    // }
    echo $updateCustomer;
} else {
    $data = [
        'status' => 405,
        'message' => $requestMethod . ' Method Not Allowed',

    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}
