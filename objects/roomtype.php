<?php
// 'roomtype' object
class Roomtype{

	// database connection and table name
	private $conn;
	private $table_name = "tblroomtype";

	// object properties
	public $roomtypeid;
	public $accomid;
	public $adults;
	public $children;
	public $roomdesc;
	public $price;
			
	// constructor
	public function __construct($db){
		$this->conn = $db;
	}
	
	function roomPersons() {
		$query="Select * FROM " . $this->table_name . " r
		LEFT JOIN
			tblaccomodation a 
			ON
			r.ACCOMID=a.ACCOMID 
		WHERE adults=? AND children=?";
									
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
				
		// bind values
		$stmt->bindParam(1, $this->adults);
		$stmt->bindParam(2, $this->children);
				
		// execute query
		$stmt->execute();
				
		// return values
		return $stmt;
	}
		
	// list roomtype
	function readByRoomtypeId(){
		
		// select all from roomtype table
		$query="Select * from " . $this->table_name . "
		WHERE roomtypeid=?";
		
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
		
		// bind values
		$stmt->bindParam(1, $this->roomtypeid);
		
		// execute query
		$stmt->execute();
				
		// return values
		return $stmt;
	}
	
	// list roomtype
	function readRoomType(){
		
		// select all from roomtype table
		$query="Select * from " . $this->table_name . "";
		
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
		
		// execute query
		$stmt->execute();
				
		// return values
		return $stmt;
	}
	
	// update a roomtype record
	public function update(){

		// update query
		$query = "UPDATE
			" . $this->table_name . "
				SET
					accomid = :accomid,
					adults = :adults,	
					children = :children,
					roomdesc = :roomdesc,
					price = :price
				WHERE
					roomtypeid = :roomtypeid";

		// prepare the query
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->accomid=htmlspecialchars(strip_tags($this->accomid));
		$this->adults=htmlspecialchars(strip_tags($this->adults));
		$this->children=htmlspecialchars(strip_tags($this->children));
		$this->roomdesc=htmlspecialchars(strip_tags($this->roomdesc));
		$this->price=htmlspecialchars(strip_tags($this->price));
		$this->roomtypeid=htmlspecialchars(strip_tags($this->roomtypeid));		
				
		// bind the values from the form
		$stmt->bindParam(':accomid', $this->accomid);
        $stmt->bindParam(':adults', $this->adults);
		$stmt->bindParam(':children', $this->children);
		$stmt->bindParam(':roomdesc', $this->roomdesc);
		$stmt->bindParam(':price', $this->price);
		$stmt->bindParam(':roomtypeid', $this->roomtypeid);		

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	
	// delete the roomtype record
	function delete(){

		// delete roomtype query
		$query = "DELETE FROM " . $this->table_name . " WHERE roomtypeid = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->roomtypeid=htmlspecialchars(strip_tags($this->roomtypeid));

		// bind user id to delete
		$stmt->bindParam(1, $this->roomtypeid);

		// execute the query
		if($result = $stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	
	// create roomtype record
	function create(){
	
        // insert query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
					accomid = :accomid,
					adults = :adults,	
					children = :children,
					roomdesc = :roomdesc,
					price = :price";
												
		// prepare the query
        $stmt = $this->conn->prepare($query);

		// sanitize
		$this->accomid=htmlspecialchars(strip_tags($this->accomid));
		$this->adults=htmlspecialchars(strip_tags($this->adults));
		$this->children=htmlspecialchars(strip_tags($this->children));
		$this->roomdesc=htmlspecialchars(strip_tags($this->roomdesc));
		$this->price=htmlspecialchars(strip_tags($this->price));
		
		// bind the values
		$stmt->bindParam(':accomid', $this->accomid);
        $stmt->bindParam(':adults', $this->adults);
		$stmt->bindParam(':children', $this->children);
		$stmt->bindParam(':roomdesc', $this->roomdesc);
		$stmt->bindParam(':price', $this->price);
						
		// execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }else{
			$this->showError($stmt);
            return false;
        }
    }	
}