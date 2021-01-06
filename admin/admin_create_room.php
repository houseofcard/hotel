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
include_once '../objects/room.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$room = new Room($db);

// include login checker
include_once "admin_login_checker.php";

echo "<caption><h2 align='center'>Create Room</h2></caption>";

// if the form was submitted
if($_POST){
			
	// assigned posted values to object properties
	$room->roomnum=$_POST['roomnum'];
	$room->accomid=$_POST['accomid'];
		
	if($room->create()) {
		header('Location:admin_room.php?action=room_created');
		//echo "<p>Room was created.</p>";
	}

	// tell admin unable to create new user
	else{
		echo "<p>Unable to create Room.</p>";
	}
}

// read room button
echo "<a href='admin_room.php' class='btn btn-primary pull-left'>";
	echo "<span class='glyphicon glyphicon-list'></span> Read Room";
echo "</a>";	
?>
	
<!-- HTML form for creating a user -->
<form action='admin_create_room.php' method='post' id='create_room'>

    <div class='table-responsive'>
		<table class='table table-hover table-bordered'>

			<tr>
				<td>Room Number</td>
				<td><input type='text' name='roomnum' class='form-control' required></td>
			</tr>
			
			<tr>
				<td width='30%'>AccomID</td>
				<td width='70%'><input type='text' name='accomid' class='form-control' required></td>
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
