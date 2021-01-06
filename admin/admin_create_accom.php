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
include_once '../objects/accomodation.php';
include_once "../objects/room.php";
include_once '../objects/accomodation_image.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$accomodation = new Accomodation($db);
$room = new Room($db);
$accomimage = new AccomodationImage($db);

// include login checker
include_once "admin_login_checker.php";

echo "<caption><h2 align='center'>Create Accomodation</h2></caption>";

// read accomodation button
echo "<a href='admin_accomodation.php' class='btn btn-primary pull-right'>";
	echo "<span class='glyphicon glyphicon-list'></span> Read Accomodation";
echo "</a>";

// if the form was submitted
if($_POST){
			
	// set accomodation property values
	$accomodation->accomodation=$_POST['accom'];
	$accomodation->accomdesc=$_POST['accomdesc'];
	
	if($accomodation->create()) {
		
		$accom_id=$db->lastInsertId();
		// save the images
		$accomimage->accomid = $accom_id;
		echo $accomimage->upload();
		header('Location:admin_accomodation.php?action=accom_created');
		
		
	//	echo "<p>Accomodation was created.</p>";
			
	}

	// tell admin unable to create new accomodation
	else{
		echo "<p>Unable to create accomodation.</p>";
	}
}	
?>
	
<!-- HTML form for creating a user -->
<form action='admin_create_accom.php' method='post' id='create_accom' enctype="multipart/form-data">
     <div class='table-responsive'>
		<table class='table table-hover table-bordered'>
	
			<tr>
				<td width='30%'>Accomodation</td>
				<td width='70%'><input type='text' name='accom' class='form-control' required></td>
			</tr>
			<tr>
				<td>Accomodation Description</td>
				<td><input type='text' name='accomdesc' class='form-control' required></td>
			</tr>
			<tr>
				<td>Image(s):</td>
				<td>
					<!-- browse multiple image files -->
					<input type="file" name="files[]" class='form-control' multiple>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<button type="submit" class="btn btn-primary">
						<span class="glyphicon glyphicon-plus"></span> Create
					</button>
				</td>
			</tr>
		</table>
	</div>
</form>
