<?php
// 'order' object
class Order{

    // database connection and table name
    private $conn;
    private $table_name = "tblorder";

    // object properties
	public $orderid;
	public $transactionid;
	public $guestid;
	public $totalcost;
	public $status;
	public $created;

	// constructor
    public function __construct($db){
        $this->conn = $db;
    }

    function create(){

        // insert query
        $query = "INSERT INTO " . $this->table_name . "
                SET
					guestid = :guestid,
					transactionid = :transactionid,
					totalcost = :totalcost,
					status = :status,
					created = :created";
					
		// prepare query statement
        $stmt = $this->conn->prepare($query);

		// sanitize
		$this->guestid=htmlspecialchars(strip_tags($this->guestid));
		$this->transactionid=htmlspecialchars(strip_tags($this->transactionid));
		$this->totalcost=htmlspecialchars(strip_tags($this->totalcost));
		$this->status=htmlspecialchars(strip_tags($this->status));
		$this->created=htmlspecialchars(strip_tags($this->created));
		
		// bind values to be inserted
		$stmt->bindParam(":guestid", $this->guestid);
		$stmt->bindParam(":transactionid", $this->transactionid);
        $stmt->bindParam(":totalcost", $this->totalcost);
        $stmt->bindParam(":status", $this->status);
		$stmt->bindParam(":created", $this->created);

		// execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }else{
			$this->showError($stmt);
            return false;
        }
    }	
	
	// list order
	function readAll(){
		
		// select all from order table
		$query="SELECT  
			o.ORDERID,
			o.TRANSACTIONID,
			o.CREATED,
			o.TOTALCOST,
			o.STATUS,
			g.G_FNAME as G_FNAME,
			g.G_LNAME as G_LNAME
			
		FROM 
			" . $this->table_name . " o
			LEFT JOIN tblguest g
			ON o.GUESTID = g.GUESTID 
		WHERE 
			o.STATUS = ?
		ORDER BY
			o.CREATED DESC";		
		
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
		
		// sanitize
		$this->status=htmlspecialchars(strip_tags($this->status));

		// bind limit clause values
		$stmt->bindParam(1, $this->status);	
				
		// execute query
		$stmt->execute();
				
		// return values
		return $stmt;
	}
	
	function readOneByTransactionId(){
		
	// query to select all orders related to a guest
		$query="SELECT  
			o.ORDERID,
			o.TRANSACTIONID,
			o.CREATED,
			o.TOTALCOST,
			o.STATUS,
			g.G_FNAME as G_FNAME,
			g.G_LNAME as G_LNAME
			
		FROM 
			" . $this->table_name . " o
			LEFT JOIN tblguest g
			ON o.GUESTID = g.GUESTID 
		WHERE
			transactionid = ?";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// sanitize
		$this->guestid=htmlspecialchars(strip_tags($this->transactionid));

		// bind values
		$stmt->bindParam(1, $this->transactionid);
		
		// execute query
		$stmt->execute();

		// return values
		return $stmt;
	}
	
	function changeStatus(){

		// change status query
		$query = "UPDATE " . $this->table_name . "
				SET status = :status
				WHERE transactionid = :transactionid";

		// prepare the query
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->status=htmlspecialchars(strip_tags($this->status));
		$this->transactionid=htmlspecialchars(strip_tags($this->transactionid));

		// bind the values from the form
		// new status to be set
		$stmt->bindParam(':status', $this->status);

		// unique transaction_id of record to be edited
		$stmt->bindParam(':transactionid', $this->transactionid);

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	
	// list order by guestid
	function readAll_ByGuest(){
		
		// select all from order table
		$query="SELECT  
			o.ORDERID,
			o.TRANSACTIONID,
			o.CREATED,
			o.TOTALCOST,
			o.STATUS,
			g.G_FNAME as G_FNAME,
			g.G_LNAME as G_LNAME
			
		FROM 
			" . $this->table_name . " o
			LEFT JOIN tblguest g
			ON o.GUESTID = g.GUESTID 
		WHERE 
			o.GUESTID = ?
		ORDER BY
			o.CREATED DESC";		
		
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
		
		// sanitize
		$this->guestid=htmlspecialchars(strip_tags($this->guestid));

		// bind limit clause values
		$stmt->bindParam(1, $this->guestid);	
		
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