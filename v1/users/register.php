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

// set user property values
$user->user_name = $_POST['user_name'];
$user->password = $_POST['password'];
$user->email = $_POST['email'];
$user->created = date('Y-m-d H:i:s');

// create the user
if($user->register()){
    // create array
    $baseResponse->status = 1;
    $baseResponse->message = "Success";
    $baseResponse->data = $user;
}
else{
    $baseResponse->status = 0;
    $baseResponse->message = "Username already exists!";
    $baseResponse->data = new ArrayObject();
}
print_r($baseResponse->toJson());

