<?php
// required header
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../configs/database.php';
include_once 'User.php';
include_once '../common/BaseResponse.php';

// instantiate database and category object
$database = new Database();
$db = $database->getConnection();

// initialize object
$user = new User($db);
$baseResponse = new BaseResponse();

// set ID property of user to be edited
$user->user_name = isset($_GET['user_name']) ? $_GET['user_name'] : die();
$user->password = isset($_GET['password']) ? $_GET['password'] : die();

// read the details of user to be edited
$stmt = $user->login();


if ($stmt->rowCount() > 0) {
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $user->user_id = $row["user_id"];
    $user->user_name = $row["user_name"];
    $user->password = $row["password"];
    $user->email = $row["email"];
    $user->full_name = $row["full_name"];
    $user->address = $row["address"];
    $user->gender = $row["gender"];
    $user->created = $row["created"];


    // create array
    $baseResponse->status = 1;
    $baseResponse->message = "Success";
    $baseResponse->data = $user;
} else {
    $baseResponse->status = 0;
    $baseResponse->message = "Invalid Username or Password!";
    $baseResponse->data = new ArrayObject();
}

// make it json format
print_r($baseResponse->toJson());
