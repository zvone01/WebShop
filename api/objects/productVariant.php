<?php
class ProductVarinat{
 
    // database connection and table name
    private $conn;
    private $table_name = "product_variant";
 
    // object properties
    public $ID;
    public $ProductID;
    public $Price;
    public $ForNumPeople;
    public $Name;
    public $IsDefault;

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

    public function readByProductID($productID)
    {
        // select all query
        $query = "SELECT
        *
            FROM " . $this->table_name . "
        WHERE ProductID = ".$productID;

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
                Price=:Price, 
                ProductID=:ProductID, 
                ForNumPeople=:ForNumPeople, 
                IsDefault=:IsDefault, 
                Name=:Name ";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->Price=htmlspecialchars(strip_tags($this->Price));
        $this->ProductID=htmlspecialchars(strip_tags($this->ProductID));
        $this->ForNumPeople=htmlspecialchars(strip_tags($this->ForNumPeople));
        $this->Name=htmlspecialchars(strip_tags($this->Name));
        $this->IsDefault=htmlspecialchars(strip_tags($this->IsDefault));
    
        // bind values
        $stmt->bindParam(":Price", $this->Price);
        $stmt->bindParam(":ProductID", $this->ProductID);
        $stmt->bindParam(":ForNumPeople", $this->ForNumPeople);
        $stmt->bindParam(":Name", $this->Name);
        $stmt->bindParam(":IsDefault", $this->IsDefault);
    
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
        $this->Name = $row['Name'];
        $this->Price = $row['Price'];
        $this->ProductID = $row['ProductID'];
        $this->ForNumPeople = $row['ForNumPeople'];
    }
    // update the Product
    function update(){
    
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    Price=:Price,
                    ProductID=:ProductID, 
                    ForNumPeople=:ForNumPeople, 
                    Name=:Name 
    
                WHERE
                    ID = :ID";
                    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->Price=htmlspecialchars(strip_tags($this->Price));
        $this->ProductID=htmlspecialchars(strip_tags($this->ProductID));
        $this->ForNumPeople=htmlspecialchars(strip_tags($this->ForNumPeople));
        $this->Name=htmlspecialchars(strip_tags($this->Name));
    
        // bind values
        $stmt->bindParam(":Price", $this->Price);
        $stmt->bindParam(":ProductID", $this->ProductID);
        $stmt->bindParam(":ForNumPeople", $this->ForNumPeople);
        $stmt->bindParam(":Name", $this->Name);
        $stmt->bindParam(":ID", $this->ID);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    function updateDefault(){
    
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    Price=:Price,
                    ForNumPeople=:ForNumPeople                  
    
                WHERE

                ProductID = :ProductID
                
                AND
                
                IsDefault = 1
                ";
                    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->Price=htmlspecialchars(strip_tags($this->Price));
        $this->ForNumPeople=htmlspecialchars(strip_tags($this->ForNumPeople));
        $this->Name=htmlspecialchars(strip_tags($this->ProductID));

        // bind values
        $stmt->bindParam(":Price", $this->Price);
        $stmt->bindParam(":ProductID", $this->ProductID);
        $stmt->bindParam(":ForNumPeople", $this->ForNumPeople);

 
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }
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

    function deleteByProductId(){
       // delete query
       $query = "DELETE FROM " . $this->table_name . " WHERE ProductID = ?";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
   
       // sanitize
       $this->ID=htmlspecialchars(strip_tags($this->ProductID));
   
       // bind ID of record to delete
       $stmt->bindParam(1, $this->ProductID);
   
       // execute query
       if($stmt->execute()){
           return true;
       }
   
       return false;

    }
    // used for paging Products
    public function count(){
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_rows'];
    }

}