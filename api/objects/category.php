<?php
class Category{
 
    // database connection and table name
    private $conn;
    private $table_name = "category";
 
    // object properties
    public $ID;
    public $SubCategory;
    public $Name;
    public $OrdinalNumber;
    public $Description;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read Products
function read(){
 
    // select all query
    $query = "SELECT *  FROM " . $this->table_name . " ORDER By OrdinalNumber";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}

//TODO: Ovo bi tribalo popraviti (dodati posabni falg u bazu za menu)
function getMenus(){
 
    $query = "SELECT * FROM ".$this->table_name." WHERE Name LIKE '%Menü%'";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}

function readHighestOrder(){
 
    // select all query
    $query = "SELECT MAX(OrdinalNumber) as OrdinalNumber FROM " . $this->table_name;
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // execute query
    $stmt->execute();

   

    return $stmt->fetch(PDO::FETCH_ASSOC);

}
/*
function readPictureLink(){
 
    // select all query
    $query = "SELECT Picture  FROM " . $this->table_name .   
    "WHERE
    p.ID = ?
LIMIT
    0,1";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind ID of Product to be updated
    $stmt->bindParam(1, $this->ID);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->Picture = $row['Picture'];

}*/
function readID(){
    
    // query to read single record
    $query = "SELECT
               ID
            FROM
                " . $this->table_name . "               
            ORDER BY
                ID
            DESC LIMIT
                1";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind ID of Product to be updated
    $stmt->bindParam(1, $this->ID);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->ID = $row['ID'];
}



// create Product
function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
              SET
              Name = :Name,
              SubCategory = :SubCategory,
              Description = :Description,
              OrdinalNumber = :OrdinalNumber";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->Name=htmlspecialchars(strip_tags($this->Name));
    $this->SubCategory=htmlspecialchars(strip_tags($this->SubCategory));
    $this->Description=htmlspecialchars(strip_tags($this->Description));
   // $this->Picture=htmlspecialchars(strip_tags($this->Picture));
    $this->OrdinalNumber=htmlspecialchars(strip_tags($this->OrdinalNumber));
 
    // bind values
    $stmt->bindParam(":Name", $this->Name);
    $stmt->bindParam(":SubCategory", $this->SubCategory);
    $stmt->bindParam(':Description', $this->Description);
   // $stmt->bindParam(":Picture", $this->Picture);
    $stmt->bindParam(":OrdinalNumber", $this->OrdinalNumber);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}

// used when filling up the update Product form
function readOne(){
 
    // query to read single record
    $query = "SELECT *  FROM " . $this->table_name . " WHERE ID = ".$this->ID;

    // prepare query statement
    $stmt = $this->conn->prepare( $query );
  
    // execute query
    $stmt->execute();
 
    if($stmt->rowCount() < 1)
        return false;
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // set values to object properties
    $this->Name = $row['Name'];
    $this->OrdinalNumber = $row['OrdinalNumber'];
    $this->SubCategory = $row['SubCategory'];
    $this->Description = $row['Description'];
    return true;
}


// update the Product
function update(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                Name = :Name,
                SubCategory = :SubCategory,
                Description = :Description,
                OrdinalNumber = :OrdinalNumber
            WHERE
                ID = :ID";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->Name=htmlspecialchars(strip_tags($this->Name));
    $this->SubCategory=htmlspecialchars(strip_tags($this->SubCategory));
    $this->Description=htmlspecialchars(strip_tags($this->Description));
    $this->ID=htmlspecialchars(strip_tags($this->ID));
    $this->OrdinalNumber=htmlspecialchars(strip_tags($this->OrdinalNumber));
 
    // bind new values
    $stmt->bindParam(':Name', $this->Name);
    $stmt->bindParam(':SubCategory', $this->SubCategory);
    $stmt->bindParam(':ID', $this->ID);
    $stmt->bindParam(':Description', $this->Description);
    $stmt->bindParam(':OrdinalNumber', $this->OrdinalNumber);
 
 
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
// search Products
function search($keywords){
 
    // select all query
    $query = "SELECT
                c.Name as CategoryName, p.ID, p.Name, p.Description, p.Price, p.CategoryId, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.CategoryId = c.ID
            WHERE
                p.Name LIKE ? OR p.Description LIKE ? OR c.Name LIKE ?
            ORDER BY
                p.created DESC";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $keywords=htmlspecialchars(strip_tags($keywords));
    $keywords = "%{$keywords}%";
 
    // bind
    $stmt->bindParam(1, $keywords);
    $stmt->bindParam(2, $keywords);
    $stmt->bindParam(3, $keywords);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}

public function up(){
    $query = "UPDATE " . $this->table_name . " SET OrdinalNumber = OrdinalNumber + 1  WHERE OrdinalNumber = ". $this->OrdinalNumber;
     
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    // execute the query
    if($stmt->execute()){
        return $this->update();
    }
 
    return false;
}

public function down(){
    $query = "UPDATE " . $this->table_name . " SET OrdinalNumber = OrdinalNumber - 1  WHERE OrdinalNumber = ". $this->OrdinalNumber;
     
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    // execute the query
    if($stmt->execute()){
        return $this->update();
    }
 
    return false;
}
// read Products with pagination
public function readPaging($from_record_num, $records_per_page){
 
    // select query
    $query = "SELECT
                c.Name as CategoryName, p.ID, p.Name, p.Description, p.Price, p.CategoryId, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.CategoryId = c.ID
            ORDER BY p.created DESC
            LIMIT ?, ?";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind variable values
    $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
    $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
 
    // execute query
    $stmt->execute();
 
    // return values from database
    return $stmt;
}

// used for paging Products
public function count(){
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name ;
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
}
}

/*
function updatePicture(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                Picture=:Picture
            WHERE
                ID = :ID";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize

    $this->ID=htmlspecialchars(strip_tags($this->ID));
    $this->Picture=htmlspecialchars(strip_tags($this->Picture));
 
    // bind new values

    $stmt->bindParam(':ID', $this->ID);
    $stmt->bindParam(':Picture', $this->Picture);
 
    // execute the query
    if($stmt->execute()){

        return true;
    }
 
    return false;
}
*/
/*
function deletePictureFile(){

       // query to read single record
       $query = "SELECT
       Picture
   FROM
       " . $this->table_name . " 
   WHERE
     ID = :ID
   LIMIT
       0,1";

// prepare query statement
$stmt = $this->conn->prepare( $query );

$this->ID=htmlspecialchars(strip_tags($this->ID));

// bind new values

$stmt->bindParam(':ID', $this->ID);


// execute query
$stmt->execute();

// get retrieved row
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// set values to object properties

        $filename = "../img/c/" . $row['Picture'];        

        if (($row['Picture'] != "placeholder.png") && file_exists($filename))
        {            
            unlink($filename);
        }

          return true;
       

}
*/
/*
function deletePicture(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                Picture=:Picture
            WHERE
                ID = :ID";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize

    $this->ID=htmlspecialchars(strip_tags($this->ID));
    $this->Picture=htmlspecialchars(strip_tags($this->Picture));
 
    // bind new values

    $stmt->bindParam(':ID', $this->ID);
    $stmt->bindParam(':Picture', $this->Picture);
 
    // execute the query
    if($stmt->execute()){

        return true;
    }
 
    return false;
}
*/