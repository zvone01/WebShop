<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
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

}
else
{
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$category = new Category($db);
 
// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of product to be edited
$category->ID = $data->ID;
 
// set product property values
$category->Name = $data->Name;
$category->SubCategory = $data->SubCategory;
$category->OrdinalNumber = $data->OrdinalNumber;
$category->Description = $data->Description;
//$category->Picture = $data->Picture;
 
// update the product
if($category->update()){
    echo '{';
        echo '"message": "Categry was updated."';
    echo '}';
}
 
// if unable to update the product, tell the user
else{
    echo '{';
        echo '"message": "Unable to update category."';
    echo '}';
}
}
?>