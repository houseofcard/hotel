<?php
// 'cart_item' object
class CartItem{

	// database connection and table name
	private $conn;
	private $table_name = "tblcart_items";

	// object properties
	public $cartid;
	public $guestid;
	public $accomid;
	public $arrival;
	public $departure;
	public $days;
	public $price;
	public $adults;
	public $children;
		
	// constructor
	public function __construct($db){
		$this->conn = $db;
	}
	
	// update guest id
	function updateGuestId(){

		// update query
		$query = "UPDATE " . $this->table_name . "
				SET guestid = ?
				WHERE guestid = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// bind values
		$stmt->bindParam(1, $this->guestid);
		$stmt->bindParam(2, $_SESSION['user_id']);

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	
	// used for small Navbar
	public function countAll(){

		// query to count all data
		$query = "SELECT count(*) FROM " . $this->table_name . " WHERE guestid = ?";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// bind values
		$stmt->bindParam(1, $this->guestid);

		// execute query
		$stmt->execute();

		// get row value
		$rows = $stmt->fetch(PDO::FETCH_NUM);

		// return all data count
		return $rows[0];
	}
		
	// create cart_item
	function create(){

		// insert query
		$query = "INSERT INTO " . $this->table_name . "
			 SET
				guestid = :guestid,
				accomid = :accomid,
				arrival = :arrival,
				departure = :departure,
				days = :days,
				price = :price,
				adults = :adults,
				children = :children";
							
		// prepare the query
        $stmt = $this->conn->prepare($query);

		// sanitize
		$this->guestid=htmlspecialchars(strip_tags($this->guestid));
		$this->acccomid=htmlspecialchars(strip_tags($this->accomid));
		$this->arrival=htmlspecialchars(strip_tags($this->arrival));
		$this->departure=htmlspecialchars(strip_tags($this->departure));
		$this->days=htmlspecialchars(strip_tags($this->days));
		$this->price=htmlspecialchars(strip_tags($this->price));
		$this->adults=htmlspecialchars(strip_tags($this->adults));
		$this->children=htmlspecialchars(strip_tags($this->children));
						
		// bind the values
      	$stmt->bindParam(':guestid', $this->guestid);
		$stmt->bindParam(':accomid', $this->accomid);
        $stmt->bindParam(':arrival', $this->arrival);
		$stmt->bindParam(':departure', $this->departure);
		$stmt->bindParam(':days', $this->days);
		$stmt->bindParam(':price', $this->price);
		$stmt->bindParam(':adults', $this->adults);
		$stmt->bindParam(':children', $this->children);
						
		// execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }else{
			$this->showError($stmt);
            return false;
        }
    }	
		
	// read all cart items 
	function readAll(){
		
		// select all data
		$query="Select * from " . $this->table_name . "
			WHERE guestid = ?";
			
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
				
		// bind values
		$stmt->bindParam(1, $this->guestid);

		// execute query
		$stmt->execute();

		// return values
		return $stmt;
	}
	
	// list cart item accommodation
	function readAllWithAccom(){
		
		// select all from accomodation table
		$query="SELECT
			c.GUESTID,
			c.ACCOMID,
			c.ARRIVAL, 
			c.DEPARTURE,
			c.DAYS,
			c.PRICE,
			c.ADULTS,
			c.CHILDREN,
			a.ACCOMDESC as ACCOMDESC
			FROM
			" . $this->table_name . " c
			LEFT JOIN tblaccomodation a
			ON c.ACCOMID = a.ACCOMID
			WHERE guestid = ?";
				
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
		
		// bind values
		$stmt->bindParam(1, $this->guestid);
				
		// execute query
		$stmt->execute();
				
		// return values
		return $stmt;
	}
	
	// delete the reservation
	function deleteAllByUser(){

		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE guestid = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// bind record id
		$stmt->bindParam(1, $this->guestid);

		// execute the query
		if($result = $stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	
	// delete the reservation
	function delete(){

		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE guestid = ? AND accomid = ? AND arrival = ? AND departure = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// bind record id
		$stmt->bindParam(1, $this->guestid);
		$stmt->bindParam(2, $this->accomid);
		$stmt->bindParam(3, $this->arrival);
		$stmt->bindParam(4, $this->departure);
		
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