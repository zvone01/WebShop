<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: 'access', Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/menu.php';
include_once '../objects/product.php';
 
// instantiate database and menu object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$menu = new Menu($db);
 
 
$menu->ID = isset($_GET['id']) ? $_GET['id'] : die();
 
// query menu
$stmt = $menu->readOne();
 
// create array
$menu_arr = array(
    "ID" =>  $menu->ID,
    "Name" => $menu->Name,
    "Description" => $menu->Description,
    "Price" => $menu->Price
);
 
//get products
$product = new Product($db);
 
// query products
$stmt2 = $product->readByMenuID($menu->ID);
$num = $stmt2->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $products_arr=array();
    $menu_arr["Products"]=array();
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
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
            "Picture" => $Picture
        );
        
        array_push($menu_arr["Products"], $product_item);
    }
    
}
// make it json format
print_r(json_encode($menu_arr));


?>