<?php
ob_start(); //this is so location header works
?>
<?php
// core configuration
include_once "../config/core.php";

// headings
include_once 'layout/admin_template_header.php';

// connect to database
include_once "../config/database.php";

// include objects and classes
include_once "../objects/accomodation.php";
include_once "../objects/room.php";
include_once "../objects/accomodation_image.php";

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$accomodation = new Accomodation($db);
$room = new Room($db);
$accomimage = new AccomodationImage($db);

// include login checker
include_once "admin_login_checker.php";

//create action variable
$action = isset($_GET['action']) ? $_GET['action'] : "";

echo "<caption><h2 align='center'>Accomodation Details</h2></caption>";

if ($action=='accom_deleted') {	
	echo"<p>Accomodation was deleted!</p>";
}	
else if($action=='image_deleted') {
	echo"<p>Image was deleted!</p>";
}
else if($action=='accom_updated') {
	echo"<p>Accomodation was updated!</p>";
}	
else if($action=='accom_created') {
	echo"<p>Accomodation was created!</p>";
}

//create accomodation button 
echo "<a href='admin_create_accom.php' class='btn btn-primary pull-left'>";
	echo "<span class='glyphicon glyphicon-plus'></span> Create Accomodation";
echo "</a>";

// read the database
$stmt=$accomodation->listOfaccomodation();

// count number of rows returned
$num = $stmt->rowCount();

echo "<div class='table-responsive'>";
	echo "<table class='table table-hover table-bordered'>";

		// table headers
		echo "<tr>";
			echo "<th width='10%'>ID</th>";
			echo "<th width='15%'>Name</th>";
			echo "<th width='35%'>Description</th>";
            echo "<th width='15%'>Total Rooms</th>";
			echo "<th width='15%'>Images</th>";
          	echo "<th width='15%'>Actions</th>";
		echo "</tr>";

        // loop through the records
		while ($row_accomodation = $stmt->fetch(PDO::FETCH_ASSOC)){
			//extract($row);
			$accomid= $row_accomodation['ACCOMID'];
			$accomname= $row_accomodation['ACCOMODATION'];
			$accomdesc= $row_accomodation['ACCOMDESC'];
			$room->accomid=$accomid;
			$roomstotal=$room->countRooms();
			
			echo "<tr>";
				echo "<td>{$accomid}</td>";
				echo "<td>{$accomname}</td>";
				echo "<td>{$accomdesc}</td>";
				echo "<td>{$roomstotal}</td>";
				echo "<td>";
					// related image files to a product
					$accomimage->accomid=$accomid;
					$stmt_accom_image = $accomimage->readAll();
					$num_accom_image = $stmt_accom_image->rowCount();

					if($num_accom_image>0){
						$x=1;
						while ($row = $stmt_accom_image->fetch(PDO::FETCH_ASSOC)){
							$accom_image_name = $row['name'];
							echo "<a href='../images/{$accom_image_name}' target='_blank'>Image {$x}</a><br />";
							$x++;
						}
					}else{
						echo "<p>No images.</p>";
					}
				echo "</td>";
				
				echo "<td>";
					echo "<a href='admin_update_accom.php?id={$accomid}' class='btn btn-info btn-block'>";
						echo "<span class='glyphicon glyphicon-edit'></span> Edit";
					echo "</a>";
				
					//delete button
					echo "<a delete-id='{$accomid}' file='accom' class='btn btn-danger delete-object btn-block'>";
						echo "<span class='glyphicon glyphicon-remove'></span> Delete";
					echo "</a>";
				echo "</td>";
			echo "<tr>";
		}
     echo "</table>";
echo "</div>";

// tell the user there are no room rows in the database
if(!$num>0){
	echo "<p>No accomodation rows found.</p>";
}
?>

<?php
	include_once 'admin_template_footer.php';
?>