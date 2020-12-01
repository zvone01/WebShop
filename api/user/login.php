<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
include_once '../config/token.php';
// instantiate user object
include_once '../objects/user.php';
if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
{
}
else
{
    $database = new Database();
    $db = $database->getConnection();
     
    $user = new User($db);
     
    // get posted data
    $data = json_decode(file_get_contents("php://input"));
     
    // set user property values
    $user->UserName = $data->UserName;

    //$user->Password = $data->Password;
    
    $stmt = $user->get_user_name();
    
    if($stmt->rowCount()>0){
     
        $row = $stmt->fetch();
         
        extract($row);

        if(password_verify($data->Password, $row['Password'])) 
        {
            $token = Token::create_token($ID,$UserName);
            echo json_encode(
                array("token" => $token)
            );

        }
        
        else
        {
            http_response_code(401);
            echo json_encode(
               array("message"=> "Wrong user name or password")
            );

        }

        }
     
    else{
    
        http_response_code(401);
        echo " { error: { message: 'Unauthorised' } }" ;
}
 

}

?>