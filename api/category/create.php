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
include_once '../objects/category.php';

include_once '../config/token.php';

$headers = apache_request_headers();

if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
{

}
elseif(!Token::is_valid($headers['Authorization']))
{
    http_response_code(401);
}
else
{
 
$database = new Database();
$db = $database->getConnection();
 
$category = new Category($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set product property values
$category->Name = $data->Name;
$category->Description = $data->Description;
if( isset($_POST['SubCategory']) && $_POST['SubCategory'] != null )
{
    $category->SubCategory = $data->SubCategory;
}
else{
    $category->SubCategory = 0;
}

$category->OrdinalNumber = $data->OrdinalNumber;
//$category->Picture = $data->Picture;
 
// create the product
if($category->create()){
    echo json_encode(
        array("message" => 'Category was created')
    );
}
 
// if unable to create the product, tell the user
else{
    echo json_encode(
        array("message" => "Unable to create category",
              "error" => 1)
    );
}
}
?>