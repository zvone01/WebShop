<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/product.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$category = new Category($db);
 
// set ID property of product to be edited
$product->id = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of product to be edited
$product->readOne();
 
// create array
$product_arr = array(
    "ID" =>  $product->ID,
    "Name" => $product->Name,
    "Description" => $product->Description,
    "Price" => $product->Price,
    "CategoryId" => $product->CategoryId,
    "CategoryName" => $product->CategoryName
 
);
 
// make it json format
print_r(json_encode($product_arr));
?>