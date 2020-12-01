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
include_once '../objects/product.php';
include_once '../objects/productVariant.php';

include_once '../config/token.php';

$headers = apache_request_headers();

if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
{

}
elseif(!Token::is_valid($headers['Authorization']))
{
 
    http_response_code(401);
    echo json_encode(
                    array("message" => "Unknown user",
                          "error" => 1)     
                    );

}
else
{
    $database = new Database();
    $db = $database->getConnection();
     
    $product = new Product($db);
    
    // get posted data
    $data = json_decode(file_get_contents("php://input"));
     
    // set product property values
    $product->Name = $data->Name;
    $product->Description = $data->Description;
    $product->CategoryId = $data->CategoryId;
    $product->Picture = $data->Picture;
    $product->Price = $data->Price;
        
     
    // create the product
    if($product->create()) {

        $variant = new ProductVarinat($db);

        $variant->Price = $data->Price;
        $variant->Name = "Default";
        $variant->ForNumPeople = 1;//$data->ForNumPeople;
        $variant->IsDefault = 1;
        $product->readID();
        $variant->ProductID = $product->ID;

        if($variant->create()){
            echo json_encode(
                array("message" => 'Product was created')
            );
        }
    }
    else {
        echo json_encode(
            array("message" => "Unable to create product",
                  "error" => 1)
        );
    }



}

?>