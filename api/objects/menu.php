<?php
class Menu{
 
    // database connection and table name
    private $conn;
    private $table_name = "menu";
    // object properties
    public $ID;
    public $ProductIDs = array();
    public $Description;
    public $Name;
    public $Price;
    //array of class _product
    public $Products;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read menus
function read(){
 
    // select all query
    $query = "SELECT * FROM " . $this->table_name;
    
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}

// create menu
function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                Name=:Name, Description=:Description, Price=:Price";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->Name=htmlspecialchars(strip_tags($this->Name));
    $this->Description=htmlspecialchars(strip_tags($this->Description));
    $this->Price=htmlspecialchars(strip_tags($this->Price));
 
    // bind values
    $stmt->bindParam(":Name", $this->Name);
    $stmt->bindParam(":Description", $this->Description);
    $stmt->bindParam(":Price", $this->Price);
 
    // execute query
    if($stmt->execute()){
        //To Cehck: Maybe unsafe method to call like this.
        $this->ID = $this->conn->lastInsertId();
        return true;
    }
 
    return false;
     
}

function addProducts()
{
    $query = 'INSERT  INTO `menu_product` (`MenuID`, `ProductID`)VALUES ';
    $query_parts = array();
    foreach($this->ProductIDs as $id)
    {
        $query_parts[] = "('" . $this->ID . "', '" . $id . "')";
    }
    $query .= implode(',', $query_parts);

    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}

function removeProducts($ProductIDtoRemove)
{
    $query = 'DELETE FROM  `menu_product` WHERE ';
    $query_parts = array();
    foreach($ProductIDtoRemove as $id)
    {
        $query_parts[] = "ProductID = " . $id ;
    }
    $query .= implode(' OR ', $query_parts);
    
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}

function readOne(){
 
    // query to read single record
    $query = "SELECT * FROM " . $this->table_name."  WHERE ID = ?";
    
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind ID of Menu to be updated
    $stmt->bindParam(1, $this->ID);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->Name = $row['Name'];
    $this->Description = $row['Description'];
    $this->Price = $row['Price'];
}
// update the Menu
function update(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                Name = :Name,
                Description = :Description,
                Price = :Price
            WHERE
                ID = :ID";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->Name=htmlspecialchars(strip_tags($this->Name));
    $this->Description=htmlspecialchars(strip_tags($this->Description));
    $this->Price=htmlspecialchars(strip_tags($this->Price));
    $this->ID=htmlspecialchars(strip_tags($this->ID));
 
    // bind new values
    $stmt->bindParam(':Name', $this->Name);
    $stmt->bindParam(':Description', $this->Description);
    $stmt->bindParam(':ID', $this->ID);
    $stmt->bindParam(':Price', $this->Price);
   
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}

// delete the Menu
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


// used for paging Menus
public function count(){
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
}
}