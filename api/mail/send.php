<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 

// instantiate product object
//include_once '../objects/mail.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\POP3;

require '../PHPMailer/Exception.php';
require '../PHPMailer/SMTP.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/POP3.php';


$data = json_decode(file_get_contents("php://input"));

echo $data->MailData->FirstName;


//$pop = POP3::mai('mail.cukar.cf', 110, 30, 'secer@cukar.cf', 'lalasalj123emmail', 1);

$mail = new PHPMailer;

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'cukarmailing@gmail.com';                 // SMTP username
    $mail->Password = 'lalasalj123emmail';                           // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;          
	// TCP port to connect to

    //Recipients
    $mail->setFrom('secer@cukar.cf', 'Tomislav');
    $mail->addAddress($data->MailData->Email);     // Add a recipient        // Name is optional
    $tablica = "";
    //Attachments   // Optional 
    //Content
    foreach ($data->Cart as $proizvod)
    {

        $tablica .= "<tr>";
        $tablica .= "<td>" .$proizvod->Product->Name . "<td>";
        $tablica .= "<td>" .$proizvod->Count . "<td>";
        $tablica .= "<td>" .$proizvod->Product->Price . "<td>";
        $tablica .= "</tr>";

    }

    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Test';

    $mail->Body    = 
    //echo 
    " 
    <h1>Your Order!</h2> 
    <table border=`1`>
    <tbody>" . $tablica .
"
</tbody>
    <br> 

    <p>".$data->MailData->FirstName. " ". $data->MailData->LastName."</p>
    <p>".$data->MailData->Address.", ".$data->MailData->PostalCode." ".$data->MailData->City.", ".$data->MailData->Country."</p>
    <p>".$data->MailData->PhoneNumber."</p>
    "
    ;


    //petlja
    
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';


    /*
    <h1>Your Order!</h2>

<table>
<tbody>
<tr>
<td>Ime</td>
<td>Kolicina</td>
<td>Cijena</td>
</tr>
</tbody>
</table>

<br>

<p>Ime Prezime</p>
<p>Adresa, PostalCode City,  Country</p>
<p>Email</p>
<p>PhoneNumber</p>

    */

   $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}

/*$headers = apache_request_headers();

if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
{

}*/


//$mail = new Mail();
    
// get posted data
//$data = json_decode(file_get_contents("php://input"));
    
// set product property values
/*$mail->From = $data->From;
$mail->To = $data->To;
$mail->Text = $data->Text;
$mail->Subject = $data->Subject;


FirstName: ['', Validators.required],
LastName: ['', Validators.required],
CompanyName: ['', Validators.required],
Email: ['', Validators.email],
PhoneNumber: ['', Validators.required],
Country: ['', Validators.required],
Address: ['', Validators.required],
City: ['', Validators.required],
PostalCode: ['', Validators.required],
Note: ['']*/

?>