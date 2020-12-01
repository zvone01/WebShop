<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: 'access', Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/product.php';
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$product = new Product($db);

$categoryID = isset($_GET['categoryID']) ? $_GET['categoryID'] : 0;
$categoryOrdinalNumber =  isset($_GET['categoryOrdinalNumber']) ? $_GET['categoryOrdinalNumber'] :-1;

// query products
if($categoryOrdinalNumber >= 0)
{
    $stmt = $product->readByCategorOrdinalNumber($categoryOrdinalNumber);
}
elseif ($categoryID > 0)
{
    $stmt = $product->readByCategoryID($categoryID);
}else{
    $stmt = $product->read();
}


$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $products_arr=array();
    $products_arr["Product"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $product_item=array(
            "ID" => $ID,
            "Name" => $Name,
            "Description" => html_entity_decode($Description),
            "Price" => $Price,
            "CategoryId" => $CategoryId,
            "CategoryName" => $CategoryName,
            "Picture" => html_entity_decode($Picture)
        );
 
        array_push($products_arr["Product"], $product_item);
    }
 
    echo json_encode($products_arr);
}
 
else{
    echo json_encode(
        array("message" => "No products found!")
    );
}
?>