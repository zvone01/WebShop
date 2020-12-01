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

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\POP3;

require '../PHPMailer/Exception.php';
require '../PHPMailer/SMTP.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/POP3.php';

$configs = include('../config/config.php');

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
    $user->Email = $data->Email;
    
    $stmt = $user->get_user_by_email();
    
    if($stmt->rowCount()>0){
     
        $row = $stmt->fetch();
        extract($row);

        $user->ID = $row['ID'];
        $user->resetToken = Token::create_token_resetPass($row['ID'], $row['UserName']);
        $user->updateToken();

        $mail = new PHPMailer;

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = $configs->email->host;  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $configs->email->username;                 // SMTP username
            $mail->Password = $configs->email->pass;                           // SMTP password
            $mail->SMTPSecure = $configs->email->SMTPSecure;                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $configs->email->port;          
            // TCP port to connect to

            //Recipients
            $mail->setFrom($configs->email->adress, 'Password Reset');
            $mail->addAddress($row['Email']);     // Add a recipient        // Name is optional

            //Attachments   // Optional name

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Test';
        
            $mail->Body = "<a href='.$configs->host .'/reset-pass-menu/". $user->resetToken."'>Reset Password</a>";
            $mail->AltBody = $configs->host .'/reset-pass-menu/'. $user->resetToken;

            $mail->send();

           // http_response_code(200);
            echo json_encode(
                array("message" => "Message has been sent")
            );
        } catch (Exception $e) {
            echo json_encode(
                array("message" => 'Message could not be sent. Mailer Error: '. $mail->ErrorInfo,
                "error" => 1)
            );
        }
            
            
    }else{
        echo json_encode(
            array("message" => "Unknown user",
                  "error" => 1)
        );
    }
}
 


?>