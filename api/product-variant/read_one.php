<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/productVariant.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$ProductVarinat = new ProductVarinat($db);
 
// set ID property of product to be edited
$ProductVarinat->ID = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of product to be edited
$ProductVarinat->readOne();
 
// create array
$product_arr = array(
    "ID" =>  $ProductVarinat->ID,
    "ProductID" => $ProductVarinat->ProductID,
    "Name" => $ProductVarinat->Name,
    "Price" => $ProductVarinat->Price,
    "ForNumPeople" => $ProductVarinat->ForNumPeople
 
);
 
// make it json format
print_r(json_encode($product_arr));
?>