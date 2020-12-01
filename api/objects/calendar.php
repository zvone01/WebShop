<?php
class Calendar{
 
    // database connection and table name
    private $conn;
    private $table_name = "calendar";
 
    // object properties
    public $ID;
    public $Date;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read Products
function read(){
 
    // select all query
    $query = "SELECT *  FROM " . $this->table_name;
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}

// create Product
function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                Date=:Date";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->Date=htmlspecialchars(strip_tags($this->Date));
    
    $stmt->bindParam(":Date", $this->Date);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}

// used when filling up the update Product form
function readOne(){
 
    // query to read single record
    $query = "SELECT *  FROM " . $this->table_name . "WHERE ID = ?";

    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind ID of Product to be updated
    $stmt->bindParam(1, $this->ID);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->Date = $row['Date'];
}
// update the Product


// delete the Product
function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE ID = ?";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->ID=htmlspecialchars(strip_tags($this->ID));
 
    // bind ID of record to delete
    $stmt->bindParam(1, $this->ID);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}
}