<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
 
// include database and object file
include_once '../config/database.php';
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
    
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
    
    // prepare user object
    $cal = new calendar($db);
    
    // get user id
    $data = json_decode(file_get_contents("php://input"));
    
    // set user id to be deleted
    $cal->ID = $data->ID;

    if($cal->delete()){
        echo json_encode(
            array("message" => "Date was deleted")
        );
    }
    else{
        echo json_encode(
            array("message" => "Unable to delete date!")
        );
    }
        
    
}

?>