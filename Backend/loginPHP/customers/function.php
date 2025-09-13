<?php

// require "dbconn.php";
require "../db_conn/config.php";
function error422($massage)
{
    $data = [
        'status' => 422,
        'message' => $massage,
    ];
    header("HTTP/1.0 422 Unprocessable Entity");
    echo json_encode($data);
    exit();
}

function storeCustomer($customerInput)
{
    global $conn;

    $name = mysqli_real_escape_string($conn, $customerInput['name']);
    $email = mysqli_real_escape_string($conn, $customerInput['email']);
    $phone = mysqli_real_escape_string($conn, $customerInput['phone']);
    $address = mysqli_real_escape_string($conn, $customerInput['address']);
    $pincode = mysqli_real_escape_string($conn, $customerInput['pincode']);

    if (empty(trim($name))) {
        return error422('Enter your name');
    } elseif (empty(trim($email))) {
        return error422('Enter your email');
    } elseif (empty(trim($phone))) {
        return error422('Enter your phone');
    } elseif (empty(trim($address))) {
        return error422('Enter your address');
    } elseif (empty(trim($pincode))) {
        return error422('Enter your pincode');
    } else {
        $query = "INSERT INTO customers (name,email,phone,address,pincode) VALUES ('$name','$email','$phone','$address','$pincode')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $data = [
                'status' => 201,
                'message' => 'Customer Created Successfully',

            ];
            header("HTTP/1.0 201 Created");
            echo json_encode($data);
        } else {
            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',

            ];
            header("HTTP/1.0 500 Internal Server Error");
            echo json_encode($data);
        }
    }
}


function getCustomerList()
{
    global  $conn;
    $query = "SELECT * FROM customers";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        if (mysqli_num_rows($query_run) > 0) {

            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

            $data = [
                'status' => 200,
                'message' => 'Customer List Fetched Successfully',
                'data' => $res,
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);
        } else {
            $data = [
                'status' => 404,
                'message' => 'No Customer Found',

            ];
            header("HTTP/1.0 404 No Customer Found");
            return json_encode($data);
        }
    } else {

        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',

        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}

function getCustomer($customerParams)
{
    global $conn;
    if ($customerParams['id'] == null) {
        return error422('Enter your customer id');
    }
    $customerId = mysqli_real_escape_string($conn, $customerParams['id']);

    $query = "SELECT * FROM customers WHERE id = '$customerId'LIMIT 1";
    $result = mysqli_query($conn, $query);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $res = mysqli_fetch_assoc($result);
            $data = [
                'status' => 200,
                'message' => 'Customer Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 Ok");
            return json_encode($data);
        } else {
            $data = [
                'status' => 404,
                'message' => 'No Customer Found',

            ];
            header("HTTP/1.0 404 No Found");
            return json_encode($data);
        }
    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',

        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}


function updateCustomer($customerInput, $customerParams)
{
    global $conn;

    if (!isset($customerParams['id'])) {
        return error422('customer id is not found in URL');
    } else if ($customerParams['id'] == null) {
        return error422('Enter your customer id');
    }
    $customerId = mysqli_real_escape_string($conn, $customerParams['id']);

    $name = mysqli_real_escape_string($conn, $customerInput['name']);
    $email = mysqli_real_escape_string($conn, $customerInput['email']);
    $phone = mysqli_real_escape_string($conn, $customerInput['phone']);
    $address = mysqli_real_escape_string($conn, $customerInput['address']);
    $pincode = mysqli_real_escape_string($conn, $customerInput['pincode']);

    if (empty(trim($name))) {
        return error422('Enter your name');
    } elseif (empty(trim($email))) {
        return error422('Enter your email');
    } elseif (empty(trim($phone))) {
        return error422('Enter your phone');
    } elseif (empty(trim($address))) {
        return error422('Enter your address');
    } elseif (empty(trim($pincode))) {
        return error422('Enter your pincode');
    } else {
        $query = "UPDATE customers SET name='$name',email='$email',phone='$phone',address='$address',pincode='$pincode' WHERE id = '$customerId'LIMIT 1";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $data = [
                'status' => 200,
                'message' => 'Customer Updated Successfully',

            ];
            header("HTTP/1.0 200 Created");
            echo json_encode($data);
        } else {
            $data = [
                'status' => 500,
                'message' => 'Internal Server Error',

            ];
            header("HTTP/1.0 500 Internal Server Error");
            echo json_encode($data);
        }
    }
}
