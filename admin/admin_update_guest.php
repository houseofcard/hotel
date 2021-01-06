<!--this allow the customer admin toggle button to change shade on click-->
<!--<script src="../js/jquery-3.3.1.min.js"></script>
<script src="../styles/bootstrap-4.1.2/bootstrap.min.js"></script>-->
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
include_once '../objects/guest.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$guest = new Guest($db);

// include login checker
include_once "admin_login_checker.php";

// get id of the user to be edited
$guestid=isset($_GET['guestid']) ? $_GET['guestid'] : die('Missing guest ID.');

// set guest id property
$guest->guestid=$guestid;

$stmt = $guest->listGuestID();

while ($row_guest = $stmt->fetch(PDO::FETCH_ASSOC)){
	$id= $row_guest['GUESTID'];
	$firstname= $row_guest['G_FNAME'];
	$lastname= $row_guest['G_LNAME'];
	$address= $row_guest['G_ADDRESS'];
	$city= $row_guest['G_CITY'];
	$country= $row_guest['G_COUNTRY'];
	$zip=  $row_guest['G_ZIP'];
	$phone= $row_guest['G_PHONE'];
	$dob=$row_guest['G_DBIRTH'];
	$dob1 = new DateTime($dob);
	$dob2= $dob1->format('d-m-Y');
	$nationality= $row_guest['G_NATIONALITY'];
	$company= $row_guest['G_COMPANY'];
	$companyaddress= $row_guest['G_CADDRESS'];
	$access_level = $row_guest['ACCESS_LEVEL'];
	$current_member = $row_guest['CURRENT_MEMBER'];
	$email=$row_guest['G_EMAIL'];
}

echo "<caption><h2 align='center'>Update Guest</h2></caption>";

// read guest button
echo "<a href='admin_guest.php' class='btn btn-primary pull-right'>";
	echo "<span class='glyphicon glyphicon-list'></span> Read Guest";
echo "</a>";

// if HTML form was posted / submitted
if($_POST){
	
	// assigned posted values to object properties
	$guest->g_fname=$_POST['first_name'];
	$guest->g_lname=$_POST['last_name'];
	$guest->g_address = $_POST['address'];
	$guest->g_city = $_POST['city'];
	$guest->g_country = $_POST['country'];
	$guest->g_zip = $_POST['zip'];
	$guest->g_phone = $_POST['phone'];
	$dateofbirth=date_format(date_create( $_POST['dbirth']),'Y-m-d');
	$guest->g_dbirth=$dateofbirth;
	$guest->g_nationality = $_POST['nationality'];
	$guest->g_company = $_POST['company_name'];
	$guest->g_caddress = $_POST['company_address'];        
	$guest->access_level=$_POST['access_level'];
	$guest->current_member=$_POST['current_member'];;
	$guest->g_email = $_POST['email']; 	
	
	// update guest information
	if($guest->update()){
						
		// get currently logged in user first name
		//echo $guest->id=$_SESSION['user_id'];
		 
		//$user->readOne();

		// change saved firstname
		//$_SESSION['firstname']=$user->firstname;

		// tell user details were updated
		header('Location: admin_guest.php?action=guest_updated');
		//header('Location: admin_guest.php?action=guest_updated');
	}

	// tell user unable to update details
	else{
		echo "<p>Unable to edit guest.</p>";
	}
}
?>

<!-- HTML form to update user -->
<form action='admin_update_guest.php?guestid=<?php echo $guestid; ?>' method='post'>

	<div class='table-responsive'>
		<table class='table table-hover table-bordered'> 

	        <tr>
	            <td width='30%'>First Name</td>
	            <td width='70%'><input type='text' name='first_name' value="<?php echo $firstname; ?>" class='form-control' required></td>
	        </tr>

	        <tr>
	            <td>Last Name</td>
	            <td><input type='text' name='last_name' value="<?php echo $lastname; ?>" class='form-control' required></td>
	        </tr>
			
			<tr>
				 <td>ADDRESS:</td>
	            <td><input type='text' name='address'  value="<?php echo $address; ?>" class='form-control' required></td>
	        </tr>
			
			<tr>
				 <td>CITY:</td>
	            <td><input type='text' name='city'  value="<?php echo $city; ?>" class='form-control' ></td>
	        </tr>

			<tr>
				 <td>COUNTRY:</td>
	            <td><input type='text' name='country'  value="<?php echo $country; ?>" class='form-control' ></td>
	        </tr>

			<tr>
				 <td>ZIP CODE:</td>
	            <td><input type='text' name='zip'  value="<?php echo $zip; ?>" class='form-control' ></td>
	        </tr>	
			
			<tr>
				 <td>PHONE NUMBER:</td>
	            <td><input type='text' name='phone'  value="<?php echo $phone; ?>" class='form-control' ></td>
	        </tr>	
					
			<tr>
				 <td>DATE OF BIRTH:</td>
	            <td><input type='text' name='dbirth'  value="<?php echo $dob2; ?>" class='form-control' ></td>
	        </tr>
			
			<tr>
				 <td>NATIONALITY:</td>
	            <td><input type='text' name='nationality'  value="<?php echo $nationality; ?>" class='form-control' ></td>
	        </tr>	

			<tr>
				 <td>COMPANY NAME:</td>
	            <td><input type='text' name='company_name' value="<?php echo $company; ?>"  class='form-control' ></td>
	        </tr>	
			
			<tr>
				 <td>COMPANY ADDRESS:</td>
	            <td><input type='text' name='company_address' value="<?php echo $companyaddress; ?>" class='form-control' ></td>
	        </tr>

			<tr>
	            <td>Access Level</td>
	            <td>
					<div class="btn-group" data-toggle="buttons">

						<!-- highlight the correct access level button -->
						<label class="btn btn-default <?php echo $access_level=='Customer' ? 'active' : ''; ?>">
							<input type="radio" name="access_level" value="Customer" <?php echo $access_level=='Customer' ? 'checked' : ''; ?>> Customer
						</label>

						<label class="btn btn-default <?php echo $access_level=='Admin' ? 'active' : ''; ?>">
							<input type="radio" name="access_level" value="Admin" <?php echo $access_level=='Admin' ? 'checked' : ''; ?>> Admin
						</label>

					</div>
				</td>
	        </tr>
			
			<tr>
				 <td>CURRENT MEMBER:</td>
	            <td><input type='text' name='current_member' value="<?php echo $current_member; ?>" class='form-control' ></td>
	        </tr>
			
			<tr>
				 <td>EMAIL:</td>
	            <td><input type='text' name='email' value="<?php echo $email; ?>" class='form-control' ></td>
	        </tr>
			
			<tr>
	            <td></td>
	            <td>
					<button type="submit" class="btn btn-primary">
						<span class="glyphicon glyphicon-edit"></span> Edit Guest
					</button>
	            </td>
	        </tr>
		</table>
	</div>	
</form>

