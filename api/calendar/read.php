<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: 'access', Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/calendar.php';
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$calendar = new Calendar($db);

$stmt = $calendar->read();

// check if more than 0 record found
if($stmt->rowCount()>0){
 
    // products array
    $calendar_arr=array();
 
    // retrieve our table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $item=array(
            "ID" => $ID,
            "Date" => $Date,
        );
 
        array_push($calendar_arr, $item);
    }
 
    echo json_encode($calendar_arr);
}
 
else{
    echo json_encode(
        array("message" => "No dates found!")
    );
}
?>