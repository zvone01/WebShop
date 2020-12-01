<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate menu object
include_once '../objects/menu.php';
include_once '../objects/_product.php';
 
$database = new Database();
$db = $database->getConnection();
 
$menu = new Menu($db);
$product = new _Product();
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set menu property values
$menu->Name = $data->Name;
$menu->Description = $data->Description;
$menu->Price = $data->Price;

// create the menu
if($menu->create()){

    
    if(isset($data->Products ))
    {
        foreach($data->Products as $p)
        {
            array_push($menu->ProductIDs, $p);
        }
        if(!$menu->addProducts()){
            echo '{';
                echo '"Error": "Unable to add products."';
            echo '}';
        }
    }
     
    echo '{';
        echo '"message": "Menu was created."';
    echo '}';
}
 
// if unable to create the menu, tell the user
else{
    echo '{';
        echo '"Error": "Unable to create menu."';
    echo '}';
}
?>