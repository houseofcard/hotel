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
include_once "../objects/room.php";

// get databae connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$room = new Room($db);

// include login checker
include_once "admin_login_checker.php";

//create action variable
$action = isset($_GET['action']) ? $_GET['action'] : "";

echo "<caption><h2 align='center'>Room Details</h2></caption>";

if ($action=='room_deleted') {	
	echo"<p>Room was deleted!</p>";
}	
else if($action=='room_updated') {
	echo"<p>Room was updated!</p>";
}
else if($action=='room_created') {
	echo"<p>Room was created!</p>";
}

// create room button
echo "<a href='admin_create_room.php' class='btn btn-primary pull-left m-r-15px'>";
	echo "<span class='glyphicon glyphicon-plus'></span> Create Room";
echo "</a>";

// read the database
$stmt=$room->readRoom();

// count number of rows returned
$num = $stmt->rowCount();

echo "<div class='table-responsive'>";
	echo "<table class='table table-hover table-bordered'>";

		// table headers
		echo "<tr>";
			echo "<th width='15%'>Room ID</th>";
			echo "<th width='15%'>Room Number</th>";
			echo "<th width='15%'>Accom ID</th>";
			echo "<th width='40%'>Accom Decscription</th>";
			echo "<th width='15%'>Action</th>";
		echo "</tr>";

        // loop through the records
		while ($row_room = $stmt->fetch(PDO::FETCH_ASSOC)){
			//extract($row);
			$roomid= $row_room['ROOMID'];
			$roomnum= $row_room['ROOMNUM'];
			$accomid= $row_room['ACCOMID'];
			$accomdesc= $row_room['ACCOMDESC'];
			
			echo "<tr>";
				echo "<td>{$roomid}</td>";
				echo "<td>{$roomnum}</td>";
				echo "<td>{$accomid}</td>";
				echo "<td>{$accomdesc}</td>";
					
				echo "<td>";
					//edit button
					echo "<a href='admin_update_room.php?roomid={$roomid}' class='btn btn-info btn-block'>";
						echo "<span class='glyphicon glyphicon-edit'></span> Edit";
					echo "</a>";
				
					//delete button
					echo "<a delete-id='{$roomid}' file='room' class='btn btn-danger delete-object btn-block'>";
						echo "<span class='glyphicon glyphicon-remove'></span> Delete";
					echo "</a>";
				echo "</td>";
			echo "<tr>";
		}
     echo "</table>";
echo "</div>";

// tell the user there are no room rows in the database
if(!$num>0){
	echo "<p>No room rows found.</p>";
}
?>
<?php
include_once 'admin_template_footer.php';
?>
