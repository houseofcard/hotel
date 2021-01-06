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
include_once '../objects/roomtype.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$roomtype = new Roomtype($db);

// include login checker
include_once "admin_login_checker.php";

// get id of the room type to be edited
$roomtypeid=isset($_GET['roomtypeid']) ? $_GET['roomtypeid'] : die('Missing room type ID.');

// set room type id property
$roomtype->roomtypeid=$roomtypeid;

// read room type details
$stmt=$roomtype->readByRoomtypeId();

while ($row_roomtype = $stmt->fetch(PDO::FETCH_ASSOC)){
	//extract($row);
	$accomid= $row_roomtype['ACCOMID'];
	$adults= $row_roomtype['ADULTS'];
	$children= $row_roomtype['CHILDREN'];
	$roomdesc= $row_roomtype['ROOMDESC'];
	$price= $row_roomtype['PRICE'];
}

echo "<caption><h2 align='center'>Update Room Type</h2></caption>";

// read room type button
echo "<a href='admin_roomtype.php' class='btn btn-primary pull-left'>";
	echo "<span class='glyphicon glyphicon-list'></span> Read Room Type";
echo "</a>";

// if HTML form was posted / submitted
if($_POST){
	// assigned posted values to object properties
	$roomtype->accomid=$_POST['accomid'];
	$roomtype->adults=$_POST['adults'];
	$roomtype->children=$_POST['children'];
	$roomtype->roomdesc=$_POST['roomdesc'];
	$roomtype->price=$_POST['price'];
	// update roomtype information
	if($roomtype->update()){
		header('Location:admin_roomtype.php?action=roomtype_updated');
	}
	// tell user unable to update details
	else{
		echo "<p>Unable to edit Roomtype.</p>";
	}
}
?>

<!-- HTML form to update user -->
<form action='admin_update_roomtype.php?roomtypeid=<?php echo $roomtypeid; ?>' method='post'>

    <div class='table-responsive'>
		<table class='table table-hover table-bordered'>

			<tr>
				<td width='30%'>AccomID</td>
				<td width='70%'><input type='text' name='accomid' value="<?php echo $accomid; ?>" class='form-control' required></td>
			</tr>

			<tr>
				<td>Adults</td>
				<td><input type='text' name='adults' value="<?php echo $adults; ?>" class='form-control' required></td>
			</tr>
			
			<tr>
				<td>Children</td>
				<td><input type='text' name='children' value="<?php echo $children; ?>" class='form-control' required></td>
			</tr>
			
			<tr>
				<td>Room description</td>
				<td><input type='text' name='roomdesc' value="<?php echo $roomdesc; ?>" class='form-control' required></td>
			</tr>
			
			<tr>
				<td>Price</td>
				<td><input type='text' name='price' value="<?php echo $price; ?>" class='form-control' required></td>
			</tr>

			<tr>
				<td></td>
				<td>
					<button type="submit" class="btn btn-primary">
						<span class="glyphicon glyphicon-edit"></span> Edit Room Type
					</button>
	           </td>
			</tr>
		</table>
	</div>
</form>
