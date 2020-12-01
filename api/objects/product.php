<?php

include_once '../objects/_product.php';
class Product extends _Product{
 
    // database connection and table name
    private $conn;
    private $table_name = "product";
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read Products
function read(){
 
    // select all query
    $query = "SELECT
                c.Name as CategoryName, 
                p.ID, p.Name,
                p.Description, 
                p.CategoryId,
                p.Picture,
                p.Price
            FROM " . $this->table_name . " p
            LEFT JOIN category c
            ON  p.CategoryId = c.ID";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}

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

}


// create Product
function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                Name=:Name, Price=:Price, Description=:Description, CategoryId=:CategoryId, Picture=:Picture, OrdinalNumber=:OrdinalNumber";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->Name=htmlspecialchars(strip_tags($this->Name));
    $this->Price=htmlspecialchars(strip_tags($this->Price));
    $this->Description=htmlspecialchars(strip_tags($this->Description));
    $this->CategoryId=htmlspecialchars(strip_tags($this->CategoryId));
    $this->Picture=htmlspecialchars(strip_tags($this->Picture));
    $this->OrdinalNumber=$this->MaxInCategory();

    // bind values
    $stmt->bindParam(":Name", $this->Name);
    $stmt->bindParam(":Price", $this->Price);
    $stmt->bindParam(":Description", $this->Description);
    $stmt->bindParam(":CategoryId", $this->CategoryId);
    $stmt->bindParam(":Picture", $this->Picture);
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
    $query = "SELECT
                c.Name as CategoryName, 
                p.ID, 
                p.Name,
                p.Description, 
                p.CategoryId,
                p.Picture,
                p.OrdinalNumber,
                p.Price
            FROM " . $this->table_name . " p
            LEFT JOIN category c
            ON  p.CategoryId = c.ID
            WHERE
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
    $this->Name = $row['Name'];
    $this->Price = $row['Price'];
    $this->Description = $row['Description'];
    $this->CategoryId = $row['CategoryId'];
    $this->CategoryName = $row['CategoryName'];
    $this->Picture = $row['Picture'];
    $this->OrdinalNumber = $row['OrdinalNumber'];
    return true;
}

function readOneWithVariant($varantID) {
 
        // select all query
        $query = "SELECT
                c.Name as CategoryName, 
                p.ID, p.Name,
                p.Description, 
                p.CategoryId,
                p.Picture,
                pv.ForNumPeople as ForNumPeople,
                pv.Price,
                pv.Name as VariantName,
                pv.ID as VariantID
            FROM " . $this->table_name . " p
        LEFT JOIN category c
            ON  p.CategoryId = c.ID
        LEFT JOIN product_variant pv
            ON pv.ProductID = p.ID
        WHERE pv.ID = ".$varantID ." AND p.ID= ". $this->ID;
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    
}

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




// update the Product
function update(){
 
    // update query

    if($this->CategoryCheck() == 0)
    {
        //print_r("test");

        $query2 = "UPDATE
        " . $this->table_name . "
    SET
        OrdinalNumber = :OrdinalNumber                  
    WHERE
        ID = :ID";

        $stmt2 = $this->conn->prepare($query2);

        $this->ID=htmlspecialchars(strip_tags($this->ID));
        $this->OrdinalNumber=$this->MaxInCategory();

        $stmt2->bindParam(':ID', $this->ID);
        $stmt2->bindParam(':OrdinalNumber', $this->OrdinalNumber);

        if(!$stmt2->execute())
        {
            return false;
        }
        
    }


    $query = "UPDATE
    " . $this->table_name . "
SET
    Name = :Name,
    Description = :Description,
    CategoryId = :CategoryId
             
WHERE
    ID = :ID";

// prepare query statement
    $stmt = $this->conn->prepare($query);

 
    // sanitize
    $this->Name=htmlspecialchars(strip_tags($this->Name));
    $this->Description=htmlspecialchars(strip_tags($this->Description));
    $this->CategoryId=htmlspecialchars(strip_tags($this->CategoryId));
    $this->ID=htmlspecialchars(strip_tags($this->ID));
    $this->Picture=htmlspecialchars(strip_tags($this->Picture));


    
 
    // bind new values
    $stmt->bindParam(':Name', $this->Name);
    $stmt->bindParam(':Description', $this->Description);
    $stmt->bindParam(':CategoryId', $this->CategoryId);  
    $stmt->bindParam(':ID', $this->ID);
 
    // execute the query
    if($stmt->execute()){

        return true;
    }
 
    return false;
}

function updateOrdinals(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                OrdinalNumber = :OrdinalNumber
            WHERE
                ID = :ID";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize

    $this->ID=htmlspecialchars(strip_tags($this->ID));
    $this->OrdinalNumber=htmlspecialchars(strip_tags($this->OrdinalNumber));
 
    // bind new values

    $stmt->bindParam(':OrdinalNumber', $this->OrdinalNumber);
    $stmt->bindParam(':ID', $this->ID);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}

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

        $filename = "../img/p/" . $row['Picture'];
        

        if (($row['Picture'] != "placeholder.png") && file_exists($filename))
        {            
            unlink($filename);
        }

          return true;
       

}


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

// delete the Product
function delete(){
    $this->deleteFromMenu();
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

function deleteFromMenu(){
    $query = "DELETE FROM `menu_product` WHERE ProductID = ?";
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
                c.Name as CategoryName, 
                p.ID, p.Name,
                p.Description, 
                p.CategoryId,
                p.Picture,
                p.Price
            FROM " . $this->table_name . " p
            LEFT JOIN category c
            ON  p.CategoryId = c.ID
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
// read Products with pagination
public function readPaging($from_record_num, $records_per_page){
 
    // select query
    $query = "SELECT
                c.Name as CategoryName, 
                p.ID, p.Name,
                p.Description, 
                p.CategoryId,
                p.Picture,
                p.Price
            FROM " . $this->table_name . " p
            LEFT JOIN category c
            ON  p.CategoryId = c.ID
            LEFT JOIN product_variant pv
            ON pv.ProductID = p.ID
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
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . " ";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
}

public function countInCategory(){
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . " WHERE CategoryId= ". $this->CategoryId;
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
}

public function MaxInCategory(){
    $query = "SELECT MAX(OrdinalNumber) + 1 as maxNumber FROM " . $this->table_name . " WHERE CategoryId= ". $this->CategoryId;
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if($row['maxNumber'] == NULL)
        return 1;

    return $row['maxNumber'];
}

public function CategoryCheck(){
    $query = "SELECT MAX(OrdinalNumber) as maxNumber FROM " . $this->table_name . "  WHERE ID = ". $this->ID . " AND CategoryId = ". $this->CategoryId;
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    //print_r($row);

    if($row['maxNumber'] == NULL)
        return 0;

    return 1;
}


public function up(){
    $query = "UPDATE " . $this->table_name . " SET OrdinalNumber = OrdinalNumber + 1  WHERE OrdinalNumber = ". $this->OrdinalNumber . " AND CategoryId = ". $this->CategoryId;
     
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    // execute the query
    if($stmt->execute()){
        return $this->updateOrdinals();
    }
 
    return false;
}

public function down(){
    $query = "UPDATE " . $this->table_name . " SET OrdinalNumber = OrdinalNumber - 1  WHERE OrdinalNumber = ". $this->OrdinalNumber . " AND CategoryId = ". $this->CategoryId;
     
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    // execute the query
    if($stmt->execute()){
        return $this->updateOrdinals();
    }
 
    return false;
}


//get by menuID
public function readByMenuID($menuID)
{
        // select all query
        $query = "SELECT
                c.Name as CategoryName, 
                p.ID, p.Name,
                p.Description, 
                p.CategoryId,
                p.Picture,
                p.Price
            FROM " . $this->table_name . " p
        LEFT JOIN category c
            ON  p.CategoryId = c.ID
        INNER JOIN menu_product mp 
            ON  mp.ProductID = p.ID AND mp.MenuID = ".$menuID;

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // execute query
    $stmt->execute();

    return $stmt;
 }


//get by categoryID
public function readByCategoryID($categoryID)
{
    // select all query
    $query = "SELECT
            c.Name as CategoryName, 
            p.ID, p.Name,
            p.Description, 
            p.CategoryId,
            p.Picture,
            pv.ID as VariantID,
            pv.Name as VariantName,
            pv.ForNumPeople as ForNumPeople,
            pv.Price as VariantPrice,
            p.Price
        FROM " . $this->table_name . " p
    LEFT JOIN category c
        ON  p.CategoryId = c.ID
    LEFT JOIN product_variant pv
        ON pv.ProductID = p.ID
    WHERE p.CategoryId = ".$categoryID;

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // execute query
    $stmt->execute();

    return $stmt;
}


public function readDefault()
{
    // select all query
    $query = "SELECT
            c.Name as CategoryName,
            c.OrdinalNumber,             
            p.ID, p.Name,
            p.Description, 
            p.CategoryId,
            p.Picture,
            p.OrdinalNumber,
            pv.ForNumPeople as ForNumPeople,
            pv.Price
        FROM " . $this->table_name . " p
    LEFT JOIN category c
        ON  p.CategoryId = c.ID
    LEFT JOIN product_variant pv
        ON pv.ProductID = p.ID
    WHERE pv.IsDefault = 1
    ORDER BY c.OrdinalNumber, p.OrdinalNumber
    ";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // execute query
    $stmt->execute();

    return $stmt;
}

public function readDefaultOne()
{
    // select all query
    $query = "SELECT
            c.Name as CategoryName,
            c.OrdinalNumber,             
            p.ID, p.Name,
            p.Description, 
            p.CategoryId,
            p.Picture,
            p.OrdinalNumber,
            pv.ForNumPeople as ForNumPeople,
            pv.Price
        FROM " . $this->table_name . " p
    LEFT JOIN category c
        ON  p.CategoryId = c.ID
    LEFT JOIN product_variant pv
        ON pv.ProductID = p.ID
    WHERE pv.IsDefault = 1 AND p.ID = ?
    LIMIT
  0,1
    ";

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
$this->Description = $row['Description'];
$this->CategoryId = $row['CategoryId'];
$this->CategoryName = $row['CategoryName'];
$this->Picture = $row['Picture'];
$this->OrdinalNumber = $row['OrdinalNumber'];
return true;


}

//get by categoryID
public function readByCategorOrdinalNumber($num)
{
    // select all query
    $query = "SELECT
                c.Name as CategoryName, 
                p.ID, 
                p.Name,
                p.Description, 
                p.CategoryId,
                p.Picture,
                p.OrdinalNumber,
                pv.ID as VariantID,
                pv.Name as VariantName,
                pv.ForNumPeople as ForNumPeople,
                pv.Price as VariantPrice,
                p.Price
            FROM " . $this->table_name . " p
            LEFT JOIN category c
            ON  p.CategoryId = c.ID
            LEFT JOIN product_variant pv
            ON pv.ProductID = p.ID
            WHERE c.OrdinalNumber = ".$num."
            ORDER BY p.OrdinalNumber";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // execute query
    $stmt->execute();

    return $stmt;
}

}