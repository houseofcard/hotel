<?php
// 'guest' object
class Guest{

	// database connection and table name
	private $conn;
	private $table_name = "tblguest";
	
	// object properties
	public $guestid;
	public $g_fname;
	public $g_lname;
	public $g_address;
	public $g_city;
	public $g_country;
	public $g_zip;
	public $g_phone;
	public $g_dbirth;
	public $g_nationality;
	public $g_company;
	public $g_caddress;
	public $access_level;
	public $current_member;
	public $g_email;
	public $g_password;
				
	// constructor
	public function __construct($db){
		$this->conn = $db;
	}
	
	// check if given email exist in the database
	function emailAlreadyExists(){

		// query to check if email exists
		$query = "SELECT *	FROM " . $this->table_name . "
				WHERE g_email = ?
				LIMIT 0,1";

		// prepare the query
		$stmt = $this->conn->prepare( $query );

		// sanitize
		$this->g_email=htmlspecialchars(strip_tags($this->g_email));

		// bind given email value
		$stmt->bindParam(1, $this->g_email);

		// execute the query
		$stmt->execute();

		// get number of rows
		$num = $stmt->rowCount();

		// if email exists, assign values to object properties for easy access and use for php sessions
		if($num>0){

			// return true because email exists in the database
			return true;
		}

		// return false if email does not exist in the database
		return false;
	}
	
	// check if given email exist in the database
	function emailExists(){

		// query to check if email exists
		$query = "SELECT guestid, g_fname, g_lname, g_password, access_level, current_member 
			FROM " . $this->table_name . "
				WHERE g_email = ?";

		// prepare the query
		$stmt = $this->conn->prepare( $query );

		// sanitize
		$this->g_email=htmlspecialchars(strip_tags($this->g_email));

		// bind given email value
		$stmt->bindParam(1, $this->g_email);

		// execute the query
		$stmt->execute();

		// get number of rows
		$num = $stmt->rowCount();

		// if email exists, assign values to object properties for easy access and use for php sessions
		if($num>0){

			// get record details / values
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			// assign values to object properties
			$this->guestid = $row['guestid'];
			$this->g_fname = $row['g_fname'];
			$this->g_lname = $row['g_lname'];
			$this->g_password = $row['g_password'];
			$this->access_level = $row['access_level'];
			$this->current_member = $row['current_member'];
			
			// return true because email exists in the database
			return true;
		}

		// return false if email does not exist in the database
		return false;
	}
	
	// check password in the database
	function passwordDetails(){
		
		// query to check password
		$query = "SELECT guestid, g_password 
			FROM " . $this->table_name . "
			WHERE guestid = ?";

		// prepare the query
		$stmt = $this->conn->prepare( $query );

		// sanitize
		$this->g_email=htmlspecialchars(strip_tags($this->guestid));

		// bind given email value
		$stmt->bindParam(1, $this->guestid);

		// execute the query
		$stmt->execute();

		// get number of rows
		$num = $stmt->rowCount();

		// if email exists, assign values to object properties for easy access and use for php sessions
		if($num>0){

			// get record details / values
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			// assign values to object properties
			$this->guestid = $row['guestid'];
			$this->g_password = $row['g_password'];
						
			// return true because email exists in the database
			return true;
		}
		
		// return false if email does not exist in the database
		return false;
	}
			
	// create new guest record
    function createGuest(){

        // insert query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
					guestid = :guestid,
					g_fname = :g_fname,
					g_lname = :g_lname,
					g_address = :g_address,
					g_city = :g_city,
					g_country = :g_country,
					g_zip = :g_zip,
					g_phone = :g_phone,
					g_dbirth = :g_dbirth,
					g_nationality = :g_nationality,
					g_company = :g_company,
					g_caddress = :g_caddress,
					g_email = :g_email,
					g_password = :g_password,
					access_level =:access_level,
					current_member =:current_member";
												
		// prepare the query
        $stmt = $this->conn->prepare($query);

		// sanitize
		$this->guestid=htmlspecialchars(strip_tags($this->guestid));
		$this->g_fname=htmlspecialchars(strip_tags($this->g_fname));
		$this->g_lname=htmlspecialchars(strip_tags($this->g_lname));
		$this->g_address=htmlspecialchars(strip_tags($this->g_address));
		$this->g_city=htmlspecialchars(strip_tags($this->g_city));
		$this->g_country=htmlspecialchars(strip_tags($this->g_country));
		$this->g_zip=htmlspecialchars(strip_tags($this->g_zip));
		$this->g_phone=htmlspecialchars(strip_tags($this->g_phone));
		$this->g_dbirth=htmlspecialchars(strip_tags($this->g_dbirth));
		$this->g_nationality=htmlspecialchars(strip_tags($this->g_nationality));
		$this->g_company=htmlspecialchars(strip_tags($this->g_company));
		$this->g_caddress=htmlspecialchars(strip_tags($this->g_caddress));
		$this->g_email=htmlspecialchars(strip_tags($this->g_email));
		$this->g_password=htmlspecialchars(strip_tags($this->g_password));
		$this->access_level=htmlspecialchars(strip_tags($this->access_level));
		$this->current_member=htmlspecialchars(strip_tags($this->current_member));
				
		// bind the values
        $stmt->bindParam(':guestid', $this->guestid);
		$stmt->bindParam(':g_fname', $this->g_fname);
        $stmt->bindParam(':g_lname', $this->g_lname);
		$stmt->bindParam(':g_address', $this->g_address);
		$stmt->bindParam(':g_city', $this->g_city);
		$stmt->bindParam(':g_country', $this->g_country);
		$stmt->bindParam(':g_zip', $this->g_zip);
		$stmt->bindParam(':g_phone', $this->g_phone);
		$stmt->bindParam(':g_dbirth', $this->g_dbirth);
		$stmt->bindParam(':g_nationality', $this->g_nationality);
        $stmt->bindParam(':g_company', $this->g_company);
		$stmt->bindParam(':g_caddress', $this->g_caddress);
		$stmt->bindParam(':g_email', $this->g_email);
		// hash the password before saving to database
		//$stmt->bindParam(':g_password', $this->g_password);
		$password_hash = password_hash($this->g_password, PASSWORD_BCRYPT);
		$stmt->bindParam(':g_password', $password_hash);
		$stmt->bindParam(':access_level', $this->access_level);
		$stmt->bindParam(':current_member', $this->current_member);
				
		// execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }else{
			$this->showError($stmt);
            return false;
        }
    }	
		
	// list guest
	function listGuest(){
		
		// select all from guest table
		$query="Select * from " . $this->table_name . "";
		//WHERE guestid = ?";
		
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
		
		// bind values
		//$stmt->bindParam(1, $this->guestid);
		
		// execute query
		$stmt->execute();
				
		// return values
		return $stmt;
	}
	
	// list guest
	function listGuestID(){
		
		// select from guest table
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
	
	// update a guest record
	public function update(){

		// update query
		$query = "UPDATE
			" . $this->table_name . "
				SET
				guestid = :guestid,
					g_fname = :g_fname,
					g_lname = :g_lname,
					g_address = :g_address,
					g_city = :g_city,
					g_country = :g_country,
					g_zip = :g_zip,
					g_phone = :g_phone,
					g_dbirth = :g_dbirth,
					g_nationality = :g_nationality,
					g_company = :g_company,
					g_caddress = :g_caddress,
					access_level =:access_level,
					current_member =:current_member,
					g_email = :g_email	
				WHERE
					guestid = :guestid";

		// prepare the query
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->guestid=htmlspecialchars(strip_tags($this->guestid));
		$this->g_fname=htmlspecialchars(strip_tags($this->g_fname));
		$this->g_lname=htmlspecialchars(strip_tags($this->g_lname));
		$this->g_address=htmlspecialchars(strip_tags($this->g_address));
		$this->g_city=htmlspecialchars(strip_tags($this->g_city));
		$this->g_country=htmlspecialchars(strip_tags($this->g_country));
		$this->g_zip=htmlspecialchars(strip_tags($this->g_zip));
		$this->g_phone=htmlspecialchars(strip_tags($this->g_phone));
		$this->g_dbirth=htmlspecialchars(strip_tags($this->g_dbirth));
		$this->g_nationality=htmlspecialchars(strip_tags($this->g_nationality));
		$this->g_company=htmlspecialchars(strip_tags($this->g_company));
		$this->g_caddress=htmlspecialchars(strip_tags($this->g_caddress));
		$this->access_level=htmlspecialchars(strip_tags($this->access_level));
		$this->current_member=htmlspecialchars(strip_tags($this->current_member));
		$this->g_email=htmlspecialchars(strip_tags($this->g_email));
		
		// bind the values from the form
		$stmt->bindParam(':guestid', $this->guestid);
		$stmt->bindParam(':g_fname', $this->g_fname);
        $stmt->bindParam(':g_lname', $this->g_lname);
		$stmt->bindParam(':g_address', $this->g_address);
		$stmt->bindParam(':g_city', $this->g_city);
		$stmt->bindParam(':g_country', $this->g_country);
		$stmt->bindParam(':g_zip', $this->g_zip);
		$stmt->bindParam(':g_phone', $this->g_phone);
		$stmt->bindParam(':g_dbirth', $this->g_dbirth);
		$stmt->bindParam(':g_nationality', $this->g_nationality);
        $stmt->bindParam(':g_company', $this->g_company);
		$stmt->bindParam(':g_caddress', $this->g_caddress);
		$stmt->bindParam(':access_level', $this->access_level);
		$stmt->bindParam(':current_member', $this->current_member);
		$stmt->bindParam(':g_email', $this->g_email);
		
		// unique ID of record to be edited
		$stmt->bindParam(':guestid', $this->guestid);

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	
	// delete the guest record
	function delete(){

		// delete guest query
		$query = "DELETE FROM " . $this->table_name . " WHERE guestid = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->guestid=htmlspecialchars(strip_tags($this->guestid));

		// bind user id to delete
		$stmt->bindParam(1, $this->guestid);

		// execute the query
		if($result = $stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	
	// used in change password feature
    // user is already logged in
   function changePassword(){

		// update query
		$query = "UPDATE
					" . $this->table_name . "
				SET
					g_password = :g_password
				WHERE
					guestid = :guestid";

		// prepare the query
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->password=htmlspecialchars(strip_tags($this->g_password));
		//$this->access_code=htmlspecialchars(strip_tags($this->access_code));

		// bind the values from the form
		$password_hash = password_hash($this->g_password, PASSWORD_BCRYPT);
		$stmt->bindParam(':g_password', $password_hash);
		$stmt->bindParam(':guestid', $this->guestid);

		// execute the query
		if($stmt->execute()){
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
?>	