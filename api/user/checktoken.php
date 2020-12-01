<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../config/token.php';
 

$headers = apache_request_headers();

if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
{

}
else
{
  
    if(Token::is_valid($headers['Authorization'])){
            echo json_encode(
                array("message" => 'Token is valid')
            );
    }
     
    else{
        
        echo json_encode(
            array("message" => 'Token is not valid ',
            "error" => 1)
        );
    }

    
}