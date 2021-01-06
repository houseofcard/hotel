<?php
// 'accomodation' object
class Accomodation{

	// database connection and table name
	private $conn;
	private $table_name = "tblaccomodation";

	// object properties
	public $accomid;
	public $accomodation;
	public $accomdesc;
	public $pricerange;
		
	// constructor
	public function __construct($db){
		$this->conn = $db;
	}
	
	// list accommodation
	function listOfaccomodation(){
		
		// select all from accomodation table
		$query="Select
			a.ACCOMID, 
			a.ACCOMODATION, 
			a.ACCOMDESC, 
			a.PRICERANGE,
			i.NAME as name
			from " . $this->table_name . " a
			LEFT JOIN tblaccomimages i
			ON a.ACCOMID = i.ACCOMID";
		
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
		
		// execute query
		$stmt->execute();
				
		// return values
		return $stmt;
	}
	
	function create(){
	
        // insert query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
					accomodation = :accomodation,
					accomdesc = :accomdesc";
												
		// prepare the query
        $stmt = $this->conn->prepare($query);

		// sanitize
		$this->accomodation=htmlspecialchars(strip_tags($this->accomodation));
		$this->accomdesc=htmlspecialchars(strip_tags($this->accomdesc));
				
		// bind the values
        $stmt->bindParam(':accomodation', $this->accomodation);
		$stmt->bindParam(':accomdesc', $this->accomdesc);
       				
		// execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }else{
			$this->showError($stmt);
            return false;
        }
    }	
	
	// list accommodation
	function readByAccomId(){
		
		// select all from accomodation table
		$query="Select * from " . $this->table_name . "
		WHERE accomid=?";
		
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
		
		// bind values
		$stmt->bindParam(1, $this->accomid);
		
		// execute query
		$stmt->execute();
				
		// return values
		return $stmt;
	}
	
	// update the product
	function update(){

		// product update query
		$query = "UPDATE
					" . $this->table_name . "
				SET
					accomodation = :accomodation,
					accomdesc = :accomdesc
					
				WHERE
					accomid = :accomid";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->accomodation=htmlspecialchars(strip_tags($this->accomodation));
		$this->accomdesc=htmlspecialchars($this->accomdesc);
		$this->accomid=htmlspecialchars(strip_tags($this->accomid));
		
		// bind variable values
		$stmt->bindParam(':accomodation', $this->accomodation);
		$stmt->bindParam(':accomdesc', $this->accomdesc);
		$stmt->bindParam(':accomid', $this->accomid);
		
		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	
	// delete the accomodation record
	function delete(){

		// delete accomodation query
		$query = "DELETE FROM " . $this->table_name . " WHERE accomid = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->accomid=htmlspecialchars(strip_tags($this->accomid));

		// bind accomodation id to delete
		$stmt->bindParam(1, $this->accomid);

		// execute the query
		if($result = $stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	
	public function showError($stmt){
		echo "<pre>";
			print_r($stmt->errorInfo());
		echo "</pre>";
	}	
}