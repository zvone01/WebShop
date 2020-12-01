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
$product = new Product($db);


// query menu
$stmt = $menu->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // menu array
    $menu_arr=array();
    $menu_arr["Menu"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $menu_item=array(
            "ID" => $ID,
            "Name" => $Name,
            "Description" => $Description,
            "Price" => $Price   
            
        );

        $stmt2 = $product->readByMenuID( $ID);
        
        $menu_item["Products"]=array();
        // retrieve our table contents
        // fetch() is faster than fetchAll()
        // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
        while ($rowProduct = $stmt2->fetch(PDO::FETCH_ASSOC)){
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($rowProduct);
    
            $product_item=array(
                "ID" => $ID,
                "Name" => $Name,
                "Description" => html_entity_decode($Description),
                "Price" => $Price,
                "CategoryId" => $CategoryId,
                "CategoryName" => $CategoryName,
                "Picture" => $Picture
            );
            
            array_push($menu_item["Products"], $product_item);
        }

        array_push($menu_arr["Menu"], $menu_item);
    }
 
    echo json_encode($menu_arr);
}
 
else{
    echo json_encode(
        array("Error" => "No menu found.")
    );
}
?>