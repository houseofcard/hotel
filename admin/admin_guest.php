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
include_once "../objects/guest.php";

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$guest = new Guest($db);

// include login checker
include_once "admin_login_checker.php";

//create action variable
$action = isset($_GET['action']) ? $_GET['action'] : "";

echo "<caption><h2 align='center'>Guest Details</h2></caption>";

if ($action=='guest_deleted') {	
	echo"<p>Guest was deleted!</p>";
}	
else if($action=='guest_updated') {
	echo"<p>Guest was updated!</p>";
}
else if($action=='guest_created') {
	echo"<p>Guest was created!</p>";
}

//echo "<div class='content'>";
// create guest form 
echo "<a href='admin_create_guest.php' class='btn btn-primary pull-left'>";
	echo "<span class='glyphicon glyphicon-plus'></span> Create Guest";
echo "</a>";

// read the database
$stmt=$guest->listGuest();

// count number of rows returned
$num = $stmt->rowCount();

echo "<div class='table-responsive'>";
	echo "<table class='table table-hover table-bordered'>";
		
		// table headers
		echo "<tr>";
			echo "<th>ID</th>";
			echo "<th>Name</th>";
			echo "<th>Address</th>";
			echo "<th>Phone Number</th>";
			echo "<th>Date of Birth</th>";
			echo "<th>Nationality</th>";
			echo "<th>Company Name</th>";
			echo "<th>Company Address</th>";
			echo "<th>Access Level</th>";
			echo "<th>Current Member</th>";			
			echo "<th>Email</th>";
			echo "<th>Actions</th>";
		echo "</tr>";

		// loop through the records
		while ($row_guest = $stmt->fetch(PDO::FETCH_ASSOC)){
			//extract($row);
			$guestid= $row_guest['GUESTID'];
			$g_fname= $row_guest['G_FNAME'];
			$g_lname= $row_guest['G_LNAME'];
			$g_address= $row_guest['G_ADDRESS'];
			$g_city= $row_guest['G_CITY'];
			$g_country= $row_guest['G_COUNTRY'];
			$zip =$row_guest['G_ZIP'];
			$phone =$row_guest['G_PHONE'];
			$dob=$row_guest['G_DBIRTH'];
			$dob1 = new DateTime($dob);
			$dob2= $dob1->format('d-m-Y');
			$nationality=$row_guest['G_NATIONALITY'];
			$cname=$row_guest['G_COMPANY'];
			$caddress=$row_guest['G_CADDRESS'];
			$access_level=$row_guest['ACCESS_LEVEL'];
			$current_member=$row_guest['CURRENT_MEMBER'];
			$email=$row_guest['G_EMAIL'];
			$assword=$row_guest['ACCESS_LEVEL'];
			
			echo "<tr>";
				echo "<td>{$guestid}</td>";
				echo "<td>{$g_fname} {$g_lname}</td>";
				echo "<td>{$g_address} {$g_city} {$g_country} {$zip}</td>";
				echo "<td>{$phone}</td>";
				echo "<td>{$dob2}</td>";
				echo "<td>{$nationality}</td>";
				echo "<td>{$cname}</td>";
				echo "<td>{$caddress}</td>";
				echo "<td>{$access_level}</td>";
				echo "<td>{$current_member}</td>";
				echo "<td>{$email}</td>";
				echo "<td>";

					// edit button
					echo "<a href='admin_update_guest.php?guestid={$guestid}' class='btn btn-info btn-block'>";
						echo "<span class='glyphicon glyphicon-edit'></span> Edit";
					echo "</a>";
					
					// delete button
					echo "<a delete-id='{$guestid}' file='guest' class='btn btn-danger delete-object btn-block'>";
					//echo "<a href='admin_delete_guest.php?guestid={$guestid}' class='btn btn-danger delete-object btn-block'>";
						echo "<span class='glyphicon glyphicon-remove'></span> Delete";
					echo "</a>";
				echo "</td>";
			echo "</tr>";
		}	
	echo "</table>";	
echo "</div>";

// tell the user if there's no guest rows in the database
if(!$num>0){
	echo "<p>No guest rows found.</p>";
}
?>

<?php
	include_once 'admin_template_footer.php';
?>