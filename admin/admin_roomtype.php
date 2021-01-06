<?php
ob_start(); //this is so location header works
?>
<?php
// core configuration
include_once "../config/core.php";

// headings
include_once 'layout/admin_template_header.php';

// connect to database
include_once '../config/database.php';

// include objects and classes
include_once "../objects/roomtype.php";

// initialize utilities class
//$utils = new Utils();

// get databae connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$roomtype = new Roomtype($db);

// include login checker
include_once "admin_login_checker.php";

//create action variable
$action = isset($_GET['action']) ? $_GET['action'] : "";

echo "<caption><h2 align='center'>Room Type Details</h2></caption>";

if ($action=='roomtype_deleted') {	
	echo"<p>Room Type was deleted!</p>";
}	
else if($action=='roomtype_updated') {
	echo"<p>Room Type was updated!</p>";
}
else if($action=='roomtype_created') {
	echo"<p>Room Type was created!</p>";
}

// create roomtype button
echo "<a href='admin_create_roomtype.php' class='btn btn-primary'>";
	echo "<span class='glyphicon glyphicon-plus'></span> Create Room Type";
echo "</a>";

// read the database
$stmt=$roomtype->readRoomType();

// count number of rows returned
$num = $stmt->rowCount();

echo "<div class='table-responsive'>";
	echo "<table class='table table-hover table-bordered'>";
		
		echo "<tr>";
			echo "<th width='10%'>Room Type ID</th>";
			echo "<th width='10%'>Accom ID</th>";
			echo "<th width='10%'>Adults</th>";
			echo "<th width='10%'>Children</th>";
			echo "<th width='30%'>Room Description</th>";
			echo "<th width='10%'>Price</th>";
			echo "<th width='20%'>Action</th>";
		echo "</tr>";

		// list products from the database
		while ($row_roomtype = $stmt->fetch(PDO::FETCH_ASSOC)){
			//extract($row);
			$roomtypeid= $row_roomtype['ROOMTYPEID'];
			$accomid= $row_roomtype['ACCOMID'];
			$adults= $row_roomtype['ADULTS'];
			$children= $row_roomtype['CHILDREN'];
			$roomdesc= $row_roomtype['ROOMDESC'];
			$price= $row_roomtype['PRICE'];
						
			echo "<tr>";
				echo "<td>{$roomtypeid}</td>";
				echo "<td>{$accomid}</td>";
				echo "<td>{$adults}</td>";
				echo "<td>{$children}</td>";
				echo "<td>{$roomdesc}</td>";
				echo "<td>{$price}</td>";
				echo "<td>";
		
					// edit button
					echo "<a href='admin_update_roomtype.php?roomtypeid={$roomtypeid}' class='btn btn-info btn-block'>";
						echo "<span class='glyphicon glyphicon-edit'></span> Edit";
					echo "</a>";
					
					// delete button
					echo "<a delete-id='{$roomtypeid}' file='roomtype' class='btn btn-danger delete-object btn-block'>";
					//echo "<a href='admin_delete_roomtype.php?roomtypeid={$roomtypeid}' class='btn btn-danger delete-object btn-block'>";
						echo "<span class='glyphicon glyphicon-remove'></span> Delete";
					echo "</a>";
				echo "</td>";
			echo "<tr>";
		}

	echo "</table>";
echo "<div>";	

// tell the user there are no room type rows in the database
if (!$num>0){
	echo "<p>No room type rows found.</p>";
}
?>

<?php
	include_once 'admin_template_footer.php';
?>