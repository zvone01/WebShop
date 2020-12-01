<?php
class User{
 
    // database connection and table name
    private $conn;
    private $table_name = "user";
 
    // object properties
    public $ID;
    public $UserName;
    public $Password;
    public $ResetToken;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }


    // read users
    function read(){
    
        // select all query
        $query = "SELECT *  FROM " . $this->table_name;
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    // create user
function create(){
 
    // query to insert record
    $query = "INSERT INTO
               " . $this->table_name . " SET UserName=:UserName, Password=:Password";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->UserName=htmlspecialchars(strip_tags($this->UserName));
    $this->Password=htmlspecialchars(strip_tags($this->Password));
 
    // bind values
    $stmt->bindParam(":UserName", $this->UserName);
    $stmt->bindParam(":Password", $this->Password);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}

// delete the user
function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE ID = ?";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->ID=htmlspecialchars(strip_tags($this->ID));
 
    // bind id of record to delete
    $stmt->bindParam(1, $this->ID);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}

function get_user()
{
   // delete query
   $query = "SELECT * FROM " . $this->table_name . " WHERE UserName =:UserName AND Password=:Password";
 
   // prepare query
   $stmt = $this->conn->prepare($query);

   // sanitize
   $this->UserName=htmlspecialchars(strip_tags($this->UserName));
   $this->Password=htmlspecialchars(strip_tags($this->Password));

   // bind id of record to delete
   $stmt->bindParam(":UserName", $this->UserName);
    $stmt->bindParam(":Password", $this->Password);

  $stmt->execute();
    
  
       return $stmt;

}

function get_user_name()
{
   // delete query
   $query = "SELECT * FROM " . $this->table_name . " WHERE UserName =:UserName";
   // prepare query
   $stmt = $this->conn->prepare($query);
   // sanitize
   $this->UserName=htmlspecialchars(strip_tags($this->UserName));
   // bind id of record to delete
   $stmt->bindParam(":UserName", $this->UserName);
   
   $stmt->execute();
   return $stmt;
}

function get_user_by_email(){
    // delete query
    $query = "SELECT * FROM " . $this->table_name . " WHERE Email =:Email";
    // prepare query
    $stmt = $this->conn->prepare($query);
    // sanitize
    $this->Email=htmlspecialchars(strip_tags($this->Email));
    // bind id of record to delete
    $stmt->bindParam(":Email", $this->Email);

    $stmt->execute();
    return $stmt;
}

function updatePass(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                Password = :Password            
            WHERE
                ID = :ID";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->Password=htmlspecialchars(strip_tags($this->Password));
    $this->ID=htmlspecialchars(strip_tags($this->ID));

 
    // bind new values
    $stmt->bindParam(':Password', $this->Password);
    $stmt->bindParam(':ID', $this->ID);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }

}

function updateEmail(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                Email = :Email            
            WHERE
                ID = :ID";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->Email=htmlspecialchars(strip_tags($this->Email));
    $this->ID=htmlspecialchars(strip_tags($this->ID));

 
    // bind new values
    $stmt->bindParam(':Email', $this->Email);
    $stmt->bindParam(':ID', $this->ID);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }

}


function updateToken(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
            ResetToken = :ResetToken            
            WHERE
                ID = :ID";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->ResetToken=htmlspecialchars(strip_tags($this->ResetToken));
    $this->ID=htmlspecialchars(strip_tags($this->ID));

 
    // bind new values
    $stmt->bindParam(':ResetToken', $this->ResetToken);
    $stmt->bindParam(':ID', $this->ID);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }

}
}