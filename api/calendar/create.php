<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate calendar object
include_once '../objects/calendar.php';
include_once '../config/token.php';

$headers = apache_request_headers();

if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
{

}
elseif(!Token::is_valid($headers['Authorization']))
{

    http_response_code(401);
    echo " { error: { message: 'Unauthorised' } }" ;

}
else
{ 
    $database = new Database();
    $db = $database->getConnection();
     
    $calendar  = new Calendar($db);
    
    // get posted data
    $data = json_decode(file_get_contents("php://input"));
     
    // set product property values
    $calendar->Date = $data->Date;
     
    // create the product
    if($calendar->create()) {

        echo json_encode(
            array("message"=> "date added")
         );
    }
    else {
        echo json_encode(
            array("message"=> "unable to add date","error"=>"unable to add date")
         );
    }



}

?>