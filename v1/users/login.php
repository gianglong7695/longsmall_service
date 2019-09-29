<?php
// required header
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../configs/database.php';
include_once 'User.php';

// instantiate database and category object
$database = new Database();
$db = $database->getConnection();

// initialize object
$user = new User($db);

// set ID property of user to be edited
$user->user_name = isset($_GET['user_name']) ? $_GET['user_name'] : die();
$user->password = isset($_GET['password']) ? $_GET['password'] : die();

// read the details of user to be edited
$stmt = $user->login();


if ($stmt->rowCount() > 0) {
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // create array
    $user_arr = array(
        "status" => true,
        "message" => "Successfully Login!",
        "user_id" => $row['user_id'],
        "user_name" => $row['user_name']
    );
} else {
    $user_arr = array(
        "status" => false,
        "message" => "Invalid Username or Password!",
    );
}

// make it json format
print_r(json_encode($user_arr));