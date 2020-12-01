<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';

include_once '../objects/product.php';
include_once '../config/token.php';


$headers = apache_request_headers();

if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
{


}
elseif(!Token::is_valid($headers['Authorization']))
{
 
    http_response_code(401);     echo json_encode(         array("message" => "Unknown user",               "error" => 1)     );;

}
else
{
 

// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$product = new Product($db);
 
// set ID property of product to be edited

 
// read the details of product to be edited
$product->readID();

// create array

$data = json_decode(file_get_contents("php://input"));
 

try {
    
    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid.
    if (
        !isset($_FILES['upfile']['error']) ||
        is_array($_FILES['upfile']['error'])
    ) {
        throw new RuntimeException('Invalid parameters.');
    }

    // Check $_FILES['upfile']['error'] value.
    switch ($_FILES['upfile']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('No file sent.');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Exceeded filesize limit.');
        default:
            throw new RuntimeException('Unknown errors.');
    }

    // You should also check filesize here. 
   /* if ($_FILES['upfile']['size'] > 1000000000000) {
        throw new RuntimeException('Exceeded filesize limit.');
    }*/

    // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
    // Check MIME Type by yourself.
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = array_search(
        $finfo->file($_FILES['upfile']['tmp_name']),
        array(
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
        ),
        true
    )) {
        throw new RuntimeException('Invalid file format.');
    }

    // You should name it uniquely.
    // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
    // On this example, obtain safe unique name from its binary data.
    $product->ID = $product->ID;
    $filehash = (string)sha1(sha1_file($_FILES['upfile']['tmp_name']).date("h:i:sa"));

    if($product->deletePictureFile()){
        $product->Picture = "placeholder.png";
        if($product->deletePicture()){
            $product->Picture =  $filehash .".". $ext;

    if (!move_uploaded_file(
        $_FILES['upfile']['tmp_name'],
        sprintf('../img/p/%s.%s',
        $filehash,
            $ext
            
        )
    )) {
        throw new RuntimeException('Failed to move uploaded file.');
    }

    

    if($product->updatePicture()){
        echo '{';
            echo '"message": "File is uploaded successfully."';
        echo '}';
    }
        }
        else{
            echo '{';
                echo '"message": "Unable to delete picture"';
            echo '}';
        }
    
    }
    else{
        echo '{';
            echo '"message": "Unable to delete picture"';
        echo '}';
    }



} catch (RuntimeException $e) {

    echo $e->getMessage();

}
}

?>