<?php
// required headers
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
if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
{

}
else
{
 
// set user property values
$user->Token = $data->token;
$user->Password = password_hash($data->password, PASSWORD_DEFAULT);


//$stmt = $user->get_user();


if(Token::is_valid_pass($data->token))
{
 

    $user->Password = password_hash($data->password, PASSWORD_DEFAULT);

    $user->ID = Token::is_valid_pass($data->token)['data']['id'];

    $user->UserName = Token::is_valid_pass($data->token)['data']['username'];

    if($user->updatePass()){
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

 
else
{

 
    echo '{';
        echo '"Error": "Unable to change password."';
    echo '}';

}
}



?>