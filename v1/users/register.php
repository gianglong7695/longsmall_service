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

// set user property values
$user->user_name = $_POST['user_name'];
$user->password = $_POST['password'];
$user->email = $_POST['email'];
$user->created = date('Y-m-d H:i:s');

// create the user
if($user->register()){
    $user_arr=array(
        "status" => true,
        "message" => "Successfully register!",
        "user_id" => $user->user_id,
        "user_name" => $user->user_name
    );
}
else{
    $user_arr=array(
        "status" => false,
        "message" => "Username already exists!"
    );
}
print_r(json_encode($user_arr));

