<link rel="stylesheet" type="text/css" href="styles/login.css">

<?php
ob_start();  //this is so location header works
?>
<?php
// core configuration
include_once "config/core.php";

// headings
include_once 'layout/template_header.php';

// connect to database
include_once 'config/database.php';

// include objects and classes
include_once 'objects/guest.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$guest = new Guest($db);

// set page title
$page_title = "Edit Profile";

// include login checker
include_once "login_checker.php";

// read guest record based on session user id value
$guestid = $_SESSION['user_id'];

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
	$email=$row_guest['G_EMAIL'];
}

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
	$guest->access_level='Customer';
	$guest->current_member='yes';
	$guest->g_email = $_POST['email']; 	
	
	// update guest information
	if($guest->update()){
						
		// get currently logged in user first name
		$guest->id=$_SESSION['user_id'];
		 
		// change saved firstname
		$_SESSION['firstname']=$guest->g_fname;
		$_SESSION['lastname']=$guest->g_lname;

		// tell user details were updated
		header('Location: edit_profile.php');
	}

	// tell user unable to update details
	//else{
		//echo "<p>Unable to edit user.</p>";
	//}
}
?>
<div class="login">
	<div class="container">
		<div class="row">
			<div class="col">
	
				<h1>Edit Profile</h1>
				<br>
				<!-- HTML form to update user -->
				<form action='edit_profile.php' method='post'>

					<div class="row">
						<h3>FIRST NAME:</h3>
					</div>
					<div class="row">
						<input type='text' name='first_name' value="<?php echo $firstname; ?>" class='login_input' required>
					</div>
					
					<div class="row">
						<h3>LAST NAME:</h3>
					</div>
					<div class="row">
						<input type='text' name='last_name' value="<?php echo $lastname; ?>" class='login_input' required>
					</div>
					
					<div class="row">
						<h3>ADDRESS:</h3>
					</div>
					<div class="row">
						<input type='text' name='address'  value="<?php echo $address; ?>" class='login_input' required>
					</div>
					
					<div class="row">
						<h3>CITY:</h3>
					</div>
					<div class="row">
						<input type='text' name='city'  value="<?php echo $city; ?>" class='login_input' >
					</div>
					
					<div class="row">
						<h3>COUNTRY:</h3>
					</div>
					<div class="row">
						<input type='text' name='country'  value="<?php echo $country; ?>" class='login_input' >
					</div>
					
					<div class="row">
						<h3>ZIP CODE:</h3>
					</div>
					<div class="row">
						<input type='text' name='zip'  value="<?php echo $zip; ?>" class='login_input' >
					</div>
					
					<div class="row">
						<h3>PHONE NUMBER:</h3>
					</div>
					<div class="row">
						<input type='text' name='phone'  value="<?php echo $phone; ?>" class='login_input' >
					</div>
					
					<div class="row">
						<h3>DATE OF BIRTH:</h3>
					</div>
					<div class="row">
						<input type='text' name='dbirth'  value="<?php echo $dob2; ?>" class='login_input' >
					</div>
					
					<div class="row">
						<h3>NATIONALITY:</h3>
					</div>
					<div class="row">
						<input type='text' name='nationality'  value="<?php echo $nationality; ?>" class='login_input' >
					</div>
					
					<div class="row">
						<h3>COMPANY NAME:</h3>
					</div>
						<div class="row"><input type='text' name='company_name' value="<?php echo $company; ?>"  class='login_input' >
					</div>
					
					<div class="row">
						<h3>COMPANY ADDRESS:</h3>
					</div>
					<div class="row">
						<input type='text' name='company_address' value="<?php echo $companyaddress; ?>" class='login_input' >
					</div>	
					
					<div class="row">
						<h3>EMAIL:</h3>
					</div>
					<div class="row">	
						<input type='text' name='email' value="<?php echo $email; ?>" class='login_input' >
					</div>

					<div class="row">
						<button type="submit" name="gsubmit" class="button">EDIT PROFILE</button> 
					</div>
				</form>
			</div>
		</div>
	</div>
</div>				

<?php
	include_once 'layout/template_footer.php';
?> 
