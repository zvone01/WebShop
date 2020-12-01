<?php

class Mail{

    private $subject = "reservation";
    private $txt;
    private $from = "our@email.com";
    private $to;
    private $firstName;
    private $lastName;
    private $companyName;
    private $phoneNumber;
    private $country;
    private $address;
    private $city;
    private $postalCode;
    private $note;
    private $products; //name, total number

    function send(){
        $headers = "From:".$from;

        mail($to,$subject,$txt,$headers);
    }
    


}

?>