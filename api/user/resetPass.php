<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../config/token.php';
// instantiate user object
include_once '../objects/user.php';

$database = new Database();
$db = $database->getConnection();
 
$user = new User($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

$headers = apache_request_headers();

if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
{

}
else
{
    $user->Password = password_hash($data->Password, PASSWORD_DEFAULT);

    $user->ID = Token::is_valid($headers['Authorization'])['data']['id'];

    $user->UserName = Token::is_valid($headers['Authorization'])['data']['username'];

    //$user->updatePass();

    if($user->updatePass()){
        http_response_code(200);
        echo '{';
            echo '"message": "Password was changed"';
        echo '}';
    }
     
    else{
    
        echo '{';
            echo '"Error": "Unable to change password."';
        echo '}';
    }

    
}