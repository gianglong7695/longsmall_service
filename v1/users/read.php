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

// query users
$stmt = $user->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){
    // products array
    $user_arr=array();
    $user_arr["users"]=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $user_item =array(
            "user_id" => $user_id,
            "user_name" => $user_name,
            "password" => $password,
            "email" => $email,
            "full_name" => $full_name,
            "address" => $address,
            "gender" => $gender,
            "created" => $created
        );

        array_push($user_arr["users"], $user_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show categories data in json format
    echo json_encode($user_arr);
}


