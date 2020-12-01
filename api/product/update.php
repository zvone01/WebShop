<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/product.php';
include_once '../config/token.php';

$headers = apache_request_headers();

if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
{

}
elseif(!Token::is_valid($headers['Authorization']))
{
 
    http_response_code(401);    
     echo json_encode(array("message" => "Unknown user","error" => 1));

}
else
{
 
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$product = new Product($db);
 
// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of product to be edited
$product->ID = $data->ID;
 
// set product property values
$product->Name = $data->Name;
$product->Price = $data->Price;
$product->Description = $data->Description;
$product->CategoryId = $data->CategoryId;
$product->Picture = $data->Picture;
 
 
// update the product
if($product->update()){
    echo json_encode(
        array("message" => "Product was updated")
    );
}
 
// if unable to update the product, tell the user
else{
    echo json_encode(
        array("message" => "Unable to update product",
              "error" => 1)
    );
}
}
?>