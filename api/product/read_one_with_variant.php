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
$vID = isset($_GET['variantId']) ? $_GET['variantId'] : die();
// read the details of product to be edited

$stmt = $product->readOneWithVariant($vID);


$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $product_item=array(
            "ID" => $ID,
            "Name" => $Name,
            "Description" => html_entity_decode($Description),
            "Price" => $Price,
            "ForNumPeople" => $ForNumPeople,
            "VariantID" => $VariantID,
            "VariantName" => $VariantName,
            "VariantPrice" => $Price,
            "CategoryId" => $CategoryId,
            "CategoryName" => $CategoryName,
            "Picture" => html_entity_decode($Picture)
        );
    
 
    echo json_encode($product_item);
}
 
else{
    echo json_encode(
        array("message" => "No products found!")
    );
}
?>