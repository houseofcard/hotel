<?php
// 'room' object
class Capacity{

	// database connection and table name
	private $conn;
	private $table_name = "tblcapacity";

	// object properties
	public $capacityid;
	public $capacity;
	public $description;
	public $c_adults;
	public $c_children;
				
	// constructor
	public function __construct($db){
		$this->conn = $db;
	}
	
	// list capacity
	function readCapacity(){
		
		// select all from roomtype table
		$query="Select * from " . $this->table_name . "";
		
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
		
		// execute query
		$stmt->execute();
				
		// return values
		return $stmt;
	}
	
	// list capacity based on ID
	function readByCapacityID(){
		
		// select all from roomtype table
		$query="Select * from " . $this->table_name . "
		WHERE capacityid=?";
		
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
		
		// bind values
		$stmt->bindParam(1, $this->capacityid);
		
		// execute query
		$stmt->execute();
				
		// return values
		return $stmt;
	}
}