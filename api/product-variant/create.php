<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate product object
include_once '../objects/productVariant.php';

include_once '../config/token.php';

$headers = apache_request_headers();

if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
{

}
elseif(!Token::is_valid($headers['Authorization']))
{
    
   echo("error");

}
else
{
 
$database = new Database();
$db = $database->getConnection();
 
$ProductVarinat = new ProductVarinat($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set product property values
$ProductVarinat->Name = $data->Name;
$ProductVarinat->ProductID = $data->ProductID;
$ProductVarinat->Price = $data->Price;
$ProductVarinat->ForNumPeople = $data->ForNumPeople;

// create the product
if($ProductVarinat->create()){
    echo '{';
        echo '"message": "Product varinat was created."';
    echo '}';
}
 
// if unable to create the product varinat, tell the user
else{
    echo '{';
        echo '"message": "Unable to create product varinat."';
    echo '}';
}
}
?>