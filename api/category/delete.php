<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
 
// include database and object file
include_once '../config/database.php';
include_once '../objects/category.php';
include_once '../config/token.php';

$headers = apache_request_headers();

if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
{

}
elseif(!Token::is_valid($headers['Authorization']))
{
 
    http_response_code(401);
    echo json_encode(
        array("message" => "Unknown user",
              "error" => 1)
    );

}
else
{
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare category object
$category = new Category($db);
 
// get category id
$data = json_decode(file_get_contents("php://input"));
 
// set category id to be deleted
$category->ID = $data;

    // delete the category
    if($category->delete()){
        echo '{';
            echo '"message": "Category was deleted."';
        echo '}';
    }
    
    // if unable to delete the category
    else{
        echo '{';
            echo '"message": "Unable to delete object."';
        echo '}';
    }

}
?>