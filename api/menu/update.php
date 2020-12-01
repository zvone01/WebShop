<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/menu.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare menu object
$menu = new Menu($db);
 
// get id of menu to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of menu to be edited
$menu->ID = $data->ID;
 
// set menu property values
$menu->Name = $data->Name;
$menu->Description = $data->Description;
$menu->Price = $data->Price;

// update the menu
if($menu->update()){
    echo '{';
        echo '"message": "Menu was updated."';
    echo '}';
}
 
// if unable to update the menu, tell the user
else{
    echo '{';
        echo '"Error": "Unable to update menu."';
    echo '}';
}
?>