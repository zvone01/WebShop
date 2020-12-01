<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: 'access', Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
 
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/product.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$product = new Product($db);
 
// set ID property of product to be edited
$product->ID = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of product to be edited
$product->readOne();
 
// create array
$product_arr = array(
    "ID" =>  $product->ID,
    "Name" => $product->Name,
    "Description" => $product->Description,
    "Price" => $product->Price,
    "Picture" => $product->Picture,
    "CategoryId" => $product->CategoryId,
    "CategoryName" => $product->CategoryName
 
);
 
// make it json format
print_r(json_encode($product_arr));
?>