<?php
// 'comments' object
class Comments{

	// database connection and table name
	private $conn;
	private $table_name = "tblcomments";
	
	// object properties
	public $commentid;
	public $comment_name;
	public $comment_email;
	public $subject;
	public $message;
	public $created;

	// constructor
	public function __construct($db){
		$this->conn = $db;
	}
	
	 // create new comment record
    function createComment(){

        // to get time-stamp for 'created' field
		$this->getTimestamp();

        // insert query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
					comment_name = :comment_name,
					comment_email = :comment_email,
					subject = :subject,
					message = :message,
					created = :created";
																
		// prepare the query
        $stmt = $this->conn->prepare($query);

		// sanitize
		$this->comment_name=htmlspecialchars(strip_tags($this->comment_name));
		$this->comment_email=htmlspecialchars(strip_tags($this->comment_email));
		$this->subject=htmlspecialchars(strip_tags($this->subject));
		$this->message=htmlspecialchars(strip_tags($this->message));
		$this->timestamp=htmlspecialchars(strip_tags($this->timestamp));
						
		// bind the values
        $stmt->bindParam(':comment_name', $this->comment_name);
        $stmt->bindParam(':comment_email', $this->comment_email);
		$stmt->bindParam(':subject', $this->subject);
		$stmt->bindParam(':message', $this->message);
		 $stmt->bindParam(":created", $this->timestamp);
						
		// execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }else{
			$this->showError($stmt);
            return false;
        }
    }	
	
	// list comments
	function readComment(){
		
		// select all from comments table
		$query="Select * from " . $this->table_name . "";
		
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
		
		// execute query
		$stmt->execute();
				
		// return values
		return $stmt;
	}
	
	// delete the comment record
	function delete(){

		// delete comment query
		$query = "DELETE FROM " . $this->table_name . " WHERE commentid = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->commentid=htmlspecialchars(strip_tags($this->commentid));

		// bind user id to delete
		$stmt->bindParam(1, $this->commentid);

		// execute the query
		if($result = $stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	
	// used for createComment function
	public function showError($stmt){
		echo "<pre>";
			print_r($stmt->errorInfo());
		echo "</pre>";
	}
	
	// used for the 'created' field when creating a comment
	function getTimestamp(){
		date_default_timezone_set('Pacific/Auckland');
		$this->timestamp = date('Y-m-d H:i:s');
	}
}