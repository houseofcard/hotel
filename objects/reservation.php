<?php
// 'reservation' object
class Reservation{

	// database connection and table name
	private $conn;
	private $table_name = "tblreservation";

	// object properties
	public $reserveid;
	public $transactionid;
	public $transdate;
	public $guestid;
	public $accomid;
	public $arrival;
	public $departure;
	public $adults;
	public $children;
	public $days;
	public $roomprice;
					
	// constructor
	public function __construct($db){
		$this->conn = $db;
	}

	function checkReservationDates(){
		
		// select all from reservation table
		$query="Select * from " . $this->table_name . "
		WHERE accomid=?
		AND ((arrival<=? AND departure>=?)
		OR (arrival <= ? AND departure >= ?) 
		OR (arrival>=? AND arrival<=?))";
										
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
		
		// bind values
		$stmt->bindParam(1, $this->accomid);
		$stmt->bindParam(2, $this->arrival);
		$stmt->bindParam(3, $this->arrival);
		$stmt->bindParam(4, $this->departure);
		$stmt->bindParam(5, $this->departure);		
		$stmt->bindParam(6, $this->arrival);
		$stmt->bindParam(7, $this->departure);	
		
		// execute query
		$stmt->execute();
		
		// get number of records retrieved
		$num = $stmt->rowCount();
		
		// return count
		return $num;
	}	
		
	// create new reservation record
    function createReservation(){
		
		 // insert query
        $query = "INSERT INTO " . $this->table_name . "
                SET
					transactionid = :transactionid,
					transdate =:transdate,
					guestid = :guestid,
					accomid =:accomid,
					arrival = :arrival,
					departure = :departure,
					adults = :adults,
					children = :children,
					days = :days,
					roomprice = :roomprice";
										
		// prepare the query
        $stmt = $this->conn->prepare($query);

		// sanitize
		$this->transactionid=htmlspecialchars(strip_tags($this->transactionid));
		$this->transdate=htmlspecialchars(strip_tags($this->transdate));
		$this->guestid=htmlspecialchars(strip_tags($this->guestid));
		$this->accomid=htmlspecialchars(strip_tags($this->accomid));
		$this->arrival=htmlspecialchars(strip_tags($this->arrival));
		$this->departure=htmlspecialchars(strip_tags($this->departure));
		$this->adults=htmlspecialchars(strip_tags($this->adults));
		$this->children=htmlspecialchars(strip_tags($this->children));
		$this->days=htmlspecialchars(strip_tags($this->days));
		$this->roomprice=htmlspecialchars(strip_tags($this->roomprice));
				
		// bind the values
        $stmt->bindParam(':transactionid', $this->transactionid);
		$stmt->bindParam(':transdate', $this->transdate);
		$stmt->bindParam(':guestid', $this->guestid);
		$stmt->bindParam(':accomid', $this->accomid);
        $stmt->bindParam(':arrival', $this->arrival);
		$stmt->bindParam(':departure', $this->departure);
		$stmt->bindParam(':adults', $this->adults);
		$stmt->bindParam(':children', $this->children);
		$stmt->bindParam(':days', $this->days);
		$stmt->bindParam(':roomprice', $this->roomprice);
				
		// execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }else{
			$this->showError($stmt);
            return false;
        }
    }	
	
	// read all reservations
	function readAll_TransactionID(){

		// query to select all order items
		$query = "SELECT * from " . $this->table_name . "
			WHERE transactionid = ?";
		
		// prepare query statement
		$stmt = $this->conn->prepare($query);
		
		// bind transaction id
		$stmt->bindParam(1, $this->transactionid);

		// execute query
		$stmt->execute();

		// return values
		return $stmt;
	}
	
	// read all reservations
	function readAllReservations(){

		// query to select all order items
		$query = "SELECT * from " . $this->table_name . "";
		
		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// execute query
		$stmt->execute();

		// return values
		return $stmt;
	}
	
	// read reservation with field sorting
	public function readAll_WithSorting($field, $order){

		$query = "SELECT * from " . $this->table_name . "
					ORDER BY {$field} {$order}";
					
		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// execute query
		$stmt->execute();
		
		// return values from database
		return $stmt;
	}
	
	// list cart item accommodation
	function readAllWithAccom(){
		
		// select all from accomodation table
		$query="SELECT
			r.TRANSACTIONID,
			r.TRANSDATE,
			r.GUESTID,
			r.ACCOMID,
			r.ARRIVAL, 
			r.DEPARTURE,
			r.ADULTS,
			r.CHILDREN,
			r.DAYS,
			r.ROOMPRICE,
			a.ACCOMDESC as ACCOMDESC
			FROM
			" . $this->table_name . " r
			LEFT JOIN tblaccomodation a
			ON r.ACCOMID = a.ACCOMID
			WHERE transactionid = ?";
				
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
		
		// bind values
		$stmt->bindParam(1, $this->transactionid);
				
		// execute query
		$stmt->execute();
				
		// return values
		return $stmt;
	}
	
	public function showError($stmt){
		echo "<pre>";
			print_r($stmt->errorInfo());
		echo "</pre>";
	}
}