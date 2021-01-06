<?php
ob_start();  //this is so location header works
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

// get id of the room to be edited
$roomid=isset($_GET['roomid']) ? $_GET['roomid'] : die('Missing room ID.');

// set room id property
$room->roomid=$roomid;

// read room details
$stmt=$room->readByRoomId();

 while ($row_room = $stmt->fetch(PDO::FETCH_ASSOC)){
         //extract($row);
		$roomnum=$accomd= $row_room['ROOMNUM'];
		$accomid= $row_room['ACCOMID'];
}

echo "<caption><h2 align='center'>Update Room</h2></caption>";

// read room button
echo "<a href='admin_room.php' class='btn btn-primary pull-left'>";
		echo "<span class='glyphicon glyphicon-list'></span> Read Room";
echo "</a>";

// if HTML form was posted / submitted
if($_POST){
	// assigned posted values to object properties
	$room->roomnum=$_POST['roomnum'];
	$room->accomid=$_POST['accomid'];
			
	// update room information
	if($room->update()){
		header('Location:admin_room.php?action=room_updated');
	}
	// tell user unable to update details
	else{
		echo "<p>Unable to edit Room.</p>";
	}
}
?>

<!-- HTML form to update user -->
<form action='admin_update_room.php?roomid=<?php echo $roomid; ?>' method='post'>

    <div class='table-responsive'>
		<table class='table table-hover table-bordered'>

			<tr>
				<td>Room Number</td>
				<td><input type='text' name='roomnum' value="<?php echo $roomnum; ?>" class='form-control' required></td>
			</tr>

			<tr>
				<td width='30%'>AccomID</td>
				<td width='70%'><input type='text' name='accomid' value="<?php echo $accomid; ?>" class='form-control' required></td>
			</tr>

			<tr>
				<td></td>
				<td>
					<button type="submit" class="btn btn-primary">
						<span class="glyphicon glyphicon-edit"></span> Edit Room 
					</button>
				</td>
			</tr>

		</table>
	<div>
</form>
