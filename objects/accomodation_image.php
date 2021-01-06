<?php
// 'accomodation image' object
class AccomodationImage{

    // database connection and table name
    private $conn;
    private $table_name = "tblaccomimages";

    // object properties
	public $imageid;
	public $name;
	public $accomid;
	
	// constructor
    public function __construct($db){
        $this->conn = $db;
    }
	
	// read all accomodation image related to a product
	function readAll(){

		// select query
		$query = "SELECT *
				FROM " . $this->table_name . "
				WHERE accomid = ?";
		
		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// sanitize
		$this->accomid=htmlspecialchars(strip_tags($this->accomid));

		// bind accom id variable
		$stmt->bindParam(1, $this->accomid);

		// execute query
		$stmt->execute();

		// return values
		return $stmt;
	}
	
	// upload accomodation image files
	function upload(){

		// specify valid image types / formats
		$valid_formats = array("jpg", "png");

		// specify maximum file size of file to be uploaded
		$max_file_size = 1024*3000; // 3MB

		// directory where the files will be uploaded
		$path = "../images/";

		// count or number of files
		$count = 0;
		
		// if files were posted
		if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
			// Loop $_FILES to execute all files
			foreach ($_FILES['files']['name'] as $f => $name){
				if ($_FILES['files']['error'][$f] == 4) {
					continue; // Skip file if any error found
				}

				if ($_FILES['files']['error'][$f] == 0) {
					if ($_FILES['files']['size'][$f] > $max_file_size) {
						$message[] = "$name is too large!.";
						continue; // Skip large files
					}
					elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
						$message[] = "$name is not a valid format";
						continue; // Skip invalid file formats
					}

					// No error found! Move uploaded files
					else{
						if(move_uploaded_file($_FILES["files"]["tmp_name"][$f], $path.$name)){
							
							$count++; // Number of successfully uploaded file

							// save name to database
							$this->name = $name;
							
							if($this->create()){
								// successfully added to databaes
							}
						}
					}
				}
			}
		}
	}
	
	// create product image
	function create(){

		// query to insert new product image record
		$query = "INSERT INTO  " . $this->table_name . "
				SET accomid = ?, name = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->accomid=htmlspecialchars(strip_tags($this->accomid));
		$this->name=htmlspecialchars(strip_tags($this->name));

		// bind values
		$stmt->bindParam(1, $this->accomid);
		$stmt->bindParam(2, $this->name);
		
		// execute query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	
	// delete the accomodation image
	function deleteAll(){

		// delete accomodation image query
		$query = "DELETE FROM " . $this->table_name . " WHERE accomid = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->accomid=htmlspecialchars(strip_tags($this->accomid));

		// bind product image id variable
		$stmt->bindParam(1, $this->accomid);

		// execute query
		if($result = $stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	
	// delete the accomodation image
	function delete(){

		// delete accomodation image query
		$query = "DELETE FROM " . $this->table_name . " WHERE imageid = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->imageid=htmlspecialchars(strip_tags($this->imageid));

		// bind product image id variable
		$stmt->bindParam(1, $this->imageid);

		// execute query
		if($result = $stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
}
?>