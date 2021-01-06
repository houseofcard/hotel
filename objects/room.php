<?php
// 'room' object
class Room{

	// database connection and table name
	private $conn;
	private $table_name = "tblroom";

	// object properties
	public $roomid;
	public $roomnum;
	public $accomid;
				
	// constructor
	public function __construct($db){
		$this->conn = $db;
	}
	
	// count rooms
	function countRooms(){
		
		// select all from room table
		$query="Select * from " . $this->table_name . "
		WHERE accomid=?";
				
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
		
		// bind values
		$stmt->bindParam(1, $this->accomid);
				
		// execute query
		$stmt->execute();
				
		// get number of records retrieved
		$num = $stmt->rowCount();

		// return count
		return $num;
	}
	
	// list rooms
	function readRoom(){
		
		// select all from rooms table
		$query="SELECT
			r.ROOMID, 
			r.ROOMNUM,
			r.ACCOMID,
			a.ACCOMDESC as ACCOMDESC
			FROM
			" . $this->table_name . " r
			LEFT JOIN tblaccomodation a
			ON r.ACCOMID = a.ACCOMID";
				
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
		
		// execute query
		$stmt->execute();
				
		// return values
		return $stmt;
	}
	
	// list room
	function readByRoomId(){
		
		// select from room table
		$query="Select * from " . $this->table_name . "
		WHERE roomid=?";
		
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
		
		// bind values
		$stmt->bindParam(1, $this->roomid);
				
		// execute query
		$stmt->execute();
				
		// return values
		return $stmt;
	}
	
	// update a room record
	public function update(){

		// update query
		$query = "UPDATE
			" . $this->table_name . "
				SET
					roomnum = :roomnum,
					accomid = :accomid
					
				WHERE
					roomid = :roomid";

		// prepare the query
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->roomnum=htmlspecialchars(strip_tags($this->roomnum));
		$this->accomid=htmlspecialchars(strip_tags($this->accomid));
		$this->roomid=htmlspecialchars(strip_tags($this->roomid));
				
		// bind the values from the form
		$stmt->bindParam(':roomnum', $this->roomnum);
        $stmt->bindParam(':accomid', $this->accomid);
		$stmt->bindParam(':roomid', $this->roomid);
		 
		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	// delete the room record
	function delete(){

		// delete room query
		$query = "DELETE FROM " . $this->table_name . " WHERE roomid = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->roomid=htmlspecialchars(strip_tags($this->roomid));

		// bind user id to delete
		$stmt->bindParam(1, $this->roomid);

		// execute the query
		if($result = $stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	
	// create room record
	function create(){
	
        // insert query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
					roomnum = :roomnum,
					accomid = :accomid";
																
		// prepare the query
        $stmt = $this->conn->prepare($query);

		// sanitize
		$this->roomnum=htmlspecialchars(strip_tags($this->roomnum));
		$this->accomid=htmlspecialchars(strip_tags($this->accomid));
				
		// bind the values
		$stmt->bindParam(':roomnum', $this->roomnum);
		$stmt->bindParam(':accomid', $this->accomid);
        						
		// execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }else{
			$this->showError($stmt);
            return false;
        }
    }	
}