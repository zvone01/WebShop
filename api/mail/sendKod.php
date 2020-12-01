<?php
// required headers
header("Access-Control-Allow-Origin: *");
header('Content-Type: text/html; charset=utf-8');
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\POP3;

if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
{
	
}
else{
require '../PHPMailer/Exception.php';
require '../PHPMailer/SMTP.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/POP3.php';

include_once '../config/database.php';
require '../objects/product.php';

$configs = include('../config/config.php');

$imgUrl = $configs->host .'/api/img/mail/';
$data = json_decode(file_get_contents("php://input"));

$mail = new PHPMailer(true);                       // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = $configs->email->host;  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = $configs->email->username;                 // SMTP username
    $mail->Password = $configs->email->pass;                          // SMTP password
    $mail->SMTPSecure = $configs->email->SMTPSecure;                          // Enable TLS encryption, `ssl` also accepted
    $mail->Port = $configs->email->port;   	// TCP port to connect to


    //Recipients
    $mail->setFrom($configs->email->adress, 'Trafo Hotel');
    
    $mail->addAddress($data->MailData->Email); 

    //get products from db
    
    $database = new Database();
    $db = $database->getConnection();
    
    //get products from db
    
    $database = new Database();
    $db = $database->getConnection();
    
    $exclusive = "";
    if($data->MailData->Exclusive == "True") { $exclusive = "Gesamten Raum für das Wunschdatum mieten";  };

    $receipt = "";
    if($data->MailData->Receipt == "True") { $receipt = "Getrennte Belege für jede Person";  };

    $altSuggestions ="";
    if($data->MailData->AltSuggestions == "True") { $altSuggestions ="Benötigen Sie alternative Vorschläge";};
    $tablica = "";
    $total = 0;
    foreach ($data->Cart as $proizvod)
    {
        //read product from db
        $product = new Product($db);
        $product->ID = $proizvod->Product->ID;
        $product->readDefaultOne();

        $tablica .=' <tr>
        <td class="item-col item">
          <table cellspacing="0" cellpadding="0" width="100%">
            <tr>
              <td class="product">
                <span style="color: #4d4d4d; font-weight:bold;">'.$product->Name.'</span> <br />
              </td>
            </tr>
          </table>
        </td>
        <td class="item-col quantity">
         ' .$proizvod->Count . '
        </td>
        <td class="item-col">
         '.$product->Price * $proizvod->Count.'
        </td>
      </tr>';
      $total += $product->Price * $proizvod->Count; 
    }

    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Fondue Chalet request';
    $style = include('style.php');
   $template = 
'<html >
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>reservation request</title>
  '.$style.'
</head>

<body bgcolor="#f7f7f7">
<table align="center" cellpadding="0" cellspacing="0" class="container-for-gmail-android" width="100%">
  <tr>
    <td align="left" valign="top" width="100%" style="background:repeat-x url('.$imgUrl.'4E687TRe69Ld95IDWyEg_bg_top_02.jpg) #ffffff;">
      <center>
      <img src="'.$imgUrl.'logo_full_glow.png" class="force-width-gmail">
        <table cellspacing="0" cellpadding="0" width="100%" bgcolor="#ffffff" background="'.$imgUrl.'4E687TRe69Ld95IDWyEg_bg_top_02.jpg" style="background-color:transparent">
          <tr>
            <td width="100%" height="80" valign="top" style="text-align: center; vertical-align:middle;">
            <!--[if gte mso 9]>
            <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:1000;height:80px; v-text-anchor:middle;">
              <v:fill type="tile" src="'.$imgUrl.'4E687TRe69Ld95IDWyEg_bg_top_02.jpg" color="#ffffff" />
              <v:textbox inset="0,0,0,0">
            <![endif]-->
              <center>
                <table cellpadding="0" cellspacing="0" width="600" class="w320">
                  <tr>
                    <td class="pull-left mobile-header-padding-left" style="vertical-align: middle;">
                      <a href=""><img height="47" src="'.$imgUrl.'logo_full_glow.png" alt="logo"></a>
                    </td>
                    <td class="pull-right mobile-header-padding-right" style="color: #4d4d4d;">
                      <a href=""><img width="44" height="47" src="'.$imgUrl.'k8D8A7SLRuetZspHxsJk_social_08.gif" alt="twitter" /></a>
                      <a href=""><img width="38" height="47" src="'.$imgUrl.'LMPMj7JSRoCWypAvzaN3_social_09.gif" alt="facebook" /></a>
                      <a href=""><img width="40" height="47" src="'.$imgUrl.'hR33ye5FQXuDDarXCGIW_social_10.gif" alt="rss" /></a>
                    </td>
                  </tr>
                </table>
              </center>
              <!--[if gte mso 9]>
              </v:textbox>
            </v:rect>
            <![endif]-->
            </td>
          </tr>
        </table>
      </center>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top" width="100%" style="background-color: #f7f7f7;" class="content-padding">
      <center>
        <table cellspacing="0" cellpadding="0" width="600" class="w320">
          <tr>
            <td class="header-lg">
              Vielen Dank für Ihre Anfrage!
            </td>
          </tr>
          <tr>
            <td class="free-text">
            Wir werden Sie sobald wie möglich kontaktieren um ihre Anfrage zu bestätigen.
            </td>
          </tr>
          <tr>
            <td class="w320">
              <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                  <td class="mini-container-left">
                    <table cellpadding="0" cellspacing="0" width="100%">
                      <tr>
                        <td class="mini-block-padding">
                          <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse:separate !important;">
                            <tr>
                              <td class="mini-block">
                                <span class="header-sm">Ihre persönlichen Daten:</span><br />
                                '.$data->MailData->FirstName.' '. $data->MailData->LastName.' <br />
                                '.$data->MailData->CompanyName.' <br />
                                '.$data->MailData->Address.', '.$data->MailData->PostalCode.' '.$data->MailData->City.', '.$data->MailData->Country.' <br />
                                '.$data->MailData->PhoneNumber.'
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                  <td class="mini-container-right">
                    <table cellpadding="0" cellspacing="0" width="100%">
                      <tr>
                        <td class="mini-block-padding">
                          <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse:separate !important;">
                            <tr>
                              <td class="mini-block">
                                <span class="header-sm">Anfrage verschickt am:</span><br />
                                '.date("Y-m-d").'<br />
                                <span class="header-sm">Anzahl an Personen:</span> <br />
                                '.$data->PersonNum.'
                                <span class="header-sm">Reservationsnummer:</span> <br />
                               <h3> '.$data->reservationCode.' </h3>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" class="mini-container-right">
                    <table cellpadding="0" cellspacing="0" width="100%">
                      <tr>
                        <td class="mini-block-padding">
                          <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse:separate !important;">
                            <tr>
                              <td class="mini-block">
                                <span class="header-sm">Zusätzliche Optionen:</span><br />
                                '.$receipt.' <br>
                                '.$exclusive.' <br>
                                '.$altSuggestions.'
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" class="mini-container-right">
                    <table cellpadding="0" cellspacing="0" width="100%">
                      <tr>
                        <td class="mini-block-padding">
                          <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse:separate !important;">
                            <tr>
                              <td class="mini-block">
                               <span class="header-sm">Weitere Anmerkungen:</span><br />
                                 '.$data->MailData->Note.'
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </center>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top" width="100%" style="background-color: #ffffff;  border-top: 1px solid #e5e5e5; border-bottom: 1px solid #e5e5e5;">
      <center>
        <table cellpadding="0" cellspacing="0" width="600" class="w320">
            <tr>
              <td class="item-table">
                <table cellspacing="0" cellpadding="0" width="100%">
                  <tr>
                    <td class="title-dark" width="300">
                      Produkte
                    </td>
                    <td class="title-dark" width="163">
                      Menge
                    </td>
                    <td class="title-dark" width="97">
                      Menge
                    </td>
                  </tr>

                    '.$tablica.'
                  <tr>
                    <td class="item-col item mobile-row-padding"></td>
                    <td class="item-col quantity"></td>
                    <td class="item-col price"></td>
                  </tr>


                  <tr>
                    <td class="item-col item">
                    </td>
                    <td class="item-col quantity" style="text-align:right; padding-right: 10px; border-top: 1px solid #cccccc;">
                      <span class="total-space" style="font-weight: bold; color: #4d4d4d">Gesamtsumme</span>
                    </td>
                    <td class="item-col price" style="text-align: left; border-top: 1px solid #cccccc;">
                      <span class="total-space" style="font-weight:bold; color: #4d4d4d">'.$total.' CHF</span>
                    </td>
                  </tr>  
                </table>
              </td>
            </tr>
        </table>
      </center>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top" width="100%" style="background-color: #f7f7f7; height: 100px;">
      <center>
        <table cellspacing="0" cellpadding="0" width="600" class="w320">
          <tr>
            <td style="padding: 25px 0 25px">
              <strong>Blue City Hotel AG</strong><br />
              Haselstrasse 17 <br />
              5400 Baden <br /><br />
            </td>
          </tr>
        </table>
      </center>
    </td>
  </tr>
</table>
</div>
</body>
</html>';
$mail->Body = $template;
$mail->send();
  
} catch (Exception $e) {    
  echo json_encode(
    array("message" => 'Message could not be sent. Mailer Error: '. $mail->ErrorInfo,
    "error" => 1)
  );
  return;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/// send mail to guest

$mail2 = new PHPMailer(true);                              // Passing `true` enables exceptions
try {

      //Server settings
      $mail2->SMTPDebug = 0;                                 // Enable verbose debug output
      $mail2->isSMTP();                                      // Set mailer to use SMTP
      $mail2->Host = $configs->email->host;  // Specify main and backup SMTP servers
      $mail2->SMTPAuth = true;                               // Enable SMTP authentication
      $mail2->Username = $configs->email->username;  ;                 // SMTP username
      $mail2->Password = $configs->email->pass;                          // SMTP password
      $mail2->SMTPSecure = $configs->email->SMTPSecure;                          // Enable TLS encryption, `ssl` also accepted
      $mail2->Port = $configs->email->port;          
    // TCP port to connect to
    foreach($configs->email->addressesTrafohotel as $e){
      $mail->addAddress($e);  
    }    // Add a recipient        // Name is optional
      //Recipients
      $mail2->setFrom($configs->email->adress, 'Trafo Hotel');

  
      $mail2->isHTML(true);                                  // Set email format to HTML
      $mail2->Subject = 'Fondue Chalet request';
      $style = include('style.php');

   $template = 
'<html >
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Fondue Chalet resrvation request</title>
'.$style.'
</head>

<body bgcolor="#f7f7f7">
<table align="center" cellpadding="0" cellspacing="0" class="container-for-gmail-android" width="100%">
  <tr>
    <td align="left" valign="top" width="100%" style="background:repeat-x url('.$imgUrl.'4E687TRe69Ld95IDWyEg_bg_top_02.jpg) #ffffff;">
      <center>
      <img src="'.$imgUrl.'logo_full_glow.png" class="force-width-gmail">
        <table cellspacing="0" cellpadding="0" width="100%" bgcolor="#ffffff" background="'.$imgUrl.'4E687TRe69Ld95IDWyEg_bg_top_02.jpg" style="background-color:transparent">
          <tr>
            <td width="100%" height="80" valign="top" style="text-align: center; vertical-align:middle;">
            <!--[if gte mso 9]>
            <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:1000;height:80px; v-text-anchor:middle;">
              <v:fill type="tile" src="'.$imgUrl.'4E687TRe69Ld95IDWyEg_bg_top_02.jpg" color="#ffffff" />
              <v:textbox inset="0,0,0,0">
            <![endif]-->
              <!--[if gte mso 9]>
              </v:textbox>
            </v:rect>
            <![endif]-->
            </td>
          </tr>
        </table>
      </center>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top" width="100%" style="background-color: #f7f7f7;" class="content-padding">
      <center>
        <table cellspacing="0" cellpadding="0" width="600" class="w320">
          <tr>
            <td class="header-lg">
              Fondue Chatel reservation request!
            </td>
          </tr>
          <tr>
            <td class="w320">
              <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                  <td class="mini-container-left">
                    <table cellpadding="0" cellspacing="0" width="100%">
                      <tr>
                        <td class="mini-block-padding">
                          <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse:separate !important;">
                            <tr>
                              <td class="mini-block">
                                <span class="header-sm">Personal Data:</span><br />
                                '.$data->MailData->FirstName.' '. $data->MailData->LastName.' <br />
                                '.$data->MailData->CompanyName.' <br />
                                '.$data->MailData->Address.', '.$data->MailData->PostalCode.' '.$data->MailData->City.', '.$data->MailData->Country.' <br />
                                '.$data->MailData->PhoneNumber.'
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                  <td class="mini-container-right">
                    <table cellpadding="0" cellspacing="0" width="100%">
                      <tr>
                        <td class="mini-block-padding">
                          <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse:separate !important;">
                            <tr>
                              <td class="mini-block">
                                <span class="header-sm">Anfrage verschickt am:</span><br />
                                '.date("d-m-Y").'<br />
                                <span class="header-sm">Anzahl an Personen:</span> <br />
                                '.$data->PersonNum.'
                                <span class="header-sm">Reservationsnummer:</span> <br />
                               <h3> '.$data->reservationCode.' </h3>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                <td colspan="2" class="mini-container-right">
                  <table cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                      <td class="mini-block-padding">
                        <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse:separate !important;">
                          <tr>
                            <td class="mini-block">
                              <span class="header-sm">Zusätzliche Optionen:</span><br />
                              '.$receipt.'<br>
                              '.$exclusive.' <br>
                              '.$altSuggestions.'
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
                <tr>
                  <td colspan="2" class="mini-container-right">
                    <table cellpadding="0" cellspacing="0" width="100%">
                      <tr>
                        <td class="mini-block-padding">
                          <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse:separate !important;">
                            <tr>
                              <td class="mini-block">
                               <span class="header-sm">Weitere Anmerkungen:</span><br />
                                 '.$data->MailData->Note.'
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </center>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top" width="100%" style="background-color: #ffffff;  border-top: 1px solid #e5e5e5; border-bottom: 1px solid #e5e5e5;">
      <center>
        <table cellpadding="0" cellspacing="0" width="600" class="w320">
            <tr>
              <td class="item-table">
                <table cellspacing="0" cellpadding="0" width="100%">
                  <tr>
                    <td class="title-dark" width="300">
                      Produkte
                    </td>
                    <td class="title-dark" width="163">
                      Menge
                    </td>
                    <td class="title-dark" width="97">
                    Gesamtsumme
                    </td>
                  </tr>

                    '.$tablica.'
                  <tr>
                    <td class="item-col item mobile-row-padding"></td>
                    <td class="item-col quantity"></td>
                    <td class="item-col price"></td>
                  </tr>


                  <tr>
                    <td class="item-col item">
                    </td>
                    <td class="item-col quantity" style="text-align:right; padding-right: 10px; border-top: 1px solid #cccccc;">
                      <span class="total-space" style="font-weight: bold; color: #4d4d4d">Gesamtsumme</span>
                    </td>
                    <td class="item-col price" style="text-align: left; border-top: 1px solid #cccccc;">
                      <span class="total-space" style="font-weight:bold; color: #4d4d4d">'.$total.' CHF</span>
                    </td>
                  </tr>  
                </table>
              </td>
            </tr>
        </table>
      </center>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top" width="100%" style="background-color: #f7f7f7; height: 100px;">
      <center>
        <table cellspacing="0" cellpadding="0" width="600" class="w320">
          <tr>
            <td style="padding: 25px 0 25px">
              <strong>Blue City Hotel AG</strong><br />
              Haselstrasse 17 <br />
              5400 Baden <br /><br />
            </td>
          </tr>
        </table>
      </center>
    </td>
  </tr>
</table>
</div>
</body>
</html>';
$mail->Body = $template;
   $mail->send();
   echo json_encode(
    array("message" => "Message has been sent")
);
} catch (Exception $e) {
  echo json_encode(
    array("message" => 'Message could not be sent. Mailer Error: '. $mail->ErrorInfo,
    "error" => 1)
  );
  return;
}

}
?>