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
//include_once "../libs/php/utils.php";
include_once '../objects/roomtype.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$roomtype = new Roomtype($db);

// include login checker
include_once "admin_login_checker.php";

echo "<caption><h2 align='center'>Create Room Type</h2></caption>";

// read roomtype button
echo "<a href='admin_roomtype.php' class='btn btn-primary pull-left'>";
	echo "<span class='glyphicon glyphicon-list'></span> Read Room Type";
echo "</a>";

// if the form was submitted
if($_POST){
		
	// assigned posted values to object properties
	$roomtype->accomid=$_POST['accomid'];
	$roomtype->adults=$_POST['adults'];
	$roomtype->children=$_POST['children'];
	$roomtype->roomdesc=$_POST['roomdesc'];
	$roomtype->price=$_POST['price'];
	
	if($roomtype->create()) {
	
	
	header('Location:admin_roomtype.php?action=roomtype_created');
	//	echo "<p>Room Type was created.</p>";
	}

	// tell admin unable to create new room type
	else{
		echo "<p>Unable to create Room Type.</p>";
	}
}	
?>
	
<!-- HTML form for creating a room type -->
<form action='admin_create_roomtype.php' method='post' id='create_roomtype'>

	<div class='table-responsive'>
		<table class='table table-hover table-bordered'>

			<tr>
	            <td width='30%'>AccomID</td>
	            <td width='70%'><input type='text' name='accomid' class='form-control' required></td>
	        </tr>
			
			<tr>
	            <td>Adults</td>
	            <td><input type='text' name='adults' class='form-control' required></td>
	        </tr>
			
			<tr>
	            <td>Children</td>
	            <td><input type='text' name='children' class='form-control' required></td>
	        </tr>
			
			<tr>
	            <td>Room description</td>
	            <td><input type='text' name='roomdesc' class='form-control' required></td>
	        </tr>
			
			<tr>
	            <td>Price</td>
	            <td><input type='text' name='price' class='form-control' required></td>
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

