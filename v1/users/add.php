<?php
// required headers
use function Sodium\add;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../configs/database.php';
include_once 'User.php';

// instantiate database and user object
$database = new Database();
$db = $database->getConnection();

// initialize object
$user = new User($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

if(
    !empty($data->user_name) &&
    !empty($data->password) &&
    !empty($data->email)
){
    $user->user_name = $data->user_name;
    $user->password = $data->password;
    $user->email = $data->email;
    $user->created = date('Y-m-d H:i:s');

    //create the user
    if($user->add()){
        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "Product was created."));
    }else{ // if unable to create the product, tell the user
        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to create product."));
    }
}else{// tell the user data is incomplete
    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to create product. Data is incomplete."));
}