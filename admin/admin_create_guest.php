<script src="../js/jquery-3.3.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="../styles/bootstrap-4.1.2/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../styles/responsive.css">
<link rel="stylesheet" type="text/css" href="../styles/custom-navbar.css">
<link rel="stylesheet" type="text/css" href="../styles/bootstrap.css">
<!--this allow the customer admin toggle button to change shade on click-->
<script src="../styles/bootstrap-4.1.2/bootstrap.min.js"></script>
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
include_once '../objects/guest.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$guest = new Guest($db);

// include login checker
include_once "admin_login_checker.php";

// make it work in PHP 5.4
include_once "../libs/php/pw-hashing/passwordLib.php";

echo "<caption><h2 align='center'>Create Guest</h2></caption>";

// read guest button
echo "<a href='admin_guest.php' class='btn btn-primary pull-right'>";
	echo "<span class='glyphicon glyphicon-list'></span> Read Guest";
echo "</a>";

// if the form was submitted
if($_POST){
	
	// set guest property values
	$guest->g_fname = $_POST['first_name'];    
	$guest->g_lname = $_POST['last_name'];  
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
	$guest->current_member='yes';
	$guest->g_email = $_POST['email']; 
	$guest->g_password = $_POST['password']; 
	
	// make sure do not create another user when that user already exists
	if($guest->emailAlreadyExists()){
		echo "<p>Email already exists in our databse.</p>";
		echo "<p>Try again with a different email.</p>";
	}
	
	else{
		
		if($guest->createGuest()){
		
			header('Location: admin_guest.php?action=guest_created');
			// tell user new guest was created
			//echo "<p>Guest was created.</p>";
		//}else{
			//echo "<p>Unable to create guest.</p>";
		//}
		}
	}
}
?>
	
<!-- HTML form for creating a guest -->
<form action='admin_create_guest.php' method='post' id='create-guest'>

     <div class='table-responsive'>
		<table class='table table-hover table-bordered'>

	        <tr>
	            <td width='30%'>FIRST NAME:</td>
	            <td width='70%'><input type='text' name='first_name' class='form-control' required></td>
	        </tr>

	        <tr>
	            <td>LAST NAME:</td>
	            <td><input type='text' name='last_name' class='form-control' required></td>
	        </tr>
			
			<tr>
				 <td>ADDRESS:</td>
	            <td><input type='text' name='address' class='form-control' required></td>
	        </tr>
			
			<tr>
				 <td>CITY:</td>
	            <td><input type='text' name='city' class='form-control' ></td>
	        </tr>

			<tr>
				 <td>COUNTRY:</td>
	            <td><input type='text' name='country' class='form-control' ></td>
	        </tr>

			<tr>
				 <td>ZIP CODE:</td>
	            <td><input type='text' name='zip' class='form-control' ></td>
	        </tr>	
			
			<tr>
				 <td>PHONE NUMBER:</td>
	            <td><input type='text' name='phone' class='form-control' ></td>
	        </tr>	
			
		
			<tr>
				 <td>DATE OF BIRTH:</td>
	            <td><input type='date' name='dbirth' class='form-control' ></td>
	        </tr>
			
			<tr>
				 <td>NATIONALITY:</td>
	            <td><input type='text' name='nationality' class='form-control' ></td>
	        </tr>	

			<tr>
				 <td>COMPANY NAME:</td>
	            <td><input type='text' name='company_name' class='form-control' ></td>
	        </tr>	
			
			<tr>
				 <td>COMPANY ADDRESS:</td>
	            <td><input type='text' name='company_address' class='form-control' ></td>
	        </tr>	
			
			<tr>
	            <td>Access Level</td>
	            <td>
					<div class="btn-group" data-toggle="buttons">
						<label class="btn btn-default active">
							<input type="radio" name="access_level" value="Customer" checked> Customer
						</label>

						<label class="btn btn-default">
							<input type="radio" name="access_level" value="Admin"> Admin
						</label>

					</div>
				</td>
	        </tr>
			
			<tr>
				 <td>EMAIL:</td>
	            <td><input type='text' name='email' class='form-control' ></td>
	        </tr>	
			
			<tr>
				<td>PASSWORD:</td>
				<td><input type='password' name='password' class='form-control' required id='passwordInput'></td>
			</tr>	

			<tr>
	            <td>CONFIRM PASSWORD:</td>
	            <td>
					<input type='password' name='confirm_password' class='form-control' required id='confirmPasswordInput'>
					<p>
						<div class="" id="passwordStrength"></div>
					</p>
				</td>
	        </tr>		
		
			<tr>
	            <td></td>
	            <td>
					<button type="submit" class="btn btn-primary">
						<span class="glyphicon glyphicon-plus"></span> Create Guest
					</button>
	            </td>
	        </tr>

	    </table>
	</div>
</form>

<?php
include_once 'admin_template_footer.php';
?>

<script type="text/javascript">
$(document).ready(function(){
	$('#passwordInput, #confirmPasswordInput').on('keyup', function(e) {

		if($('#passwordInput').val() == '' && $('#confirmPasswordInput').val() == ''){
			$('#passwordStrength').removeClass().html('');
			return false;
		}

		if($('#passwordInput').val() != '' 
			&& $('#confirmPasswordInput').val() != '' 
			&& $('#passwordInput').val() != $('#confirmPasswordInput').val()
		){
			$('#passwordStrength').removeClass().addClass('alert alert-danger').html('Passwords do not match!');
			return false;
		}

		// Must have capital letter, numbers and lowercase letters
		var strongRegex = new RegExp("^(?=.{8,})(((?=.*[A-Z])(?=.*[a-z]))(?=.*[0-9])).*$", "g");

		// Must have either capitals and lowercase letters or lowercase and numbers
		var mediumRegex = new RegExp("^(?=.{8,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");

		// Must be at least 8 characters long
		var okRegex = new RegExp("(?=.{8,}).*", "g");

		if (okRegex.test($(this).val()) === false) {
			// If ok regex doesn't match the password
			$('#passwordStrength').removeClass().addClass('alert alert-danger').html('Password must be 8 characters long.');
		}
	
		else if (strongRegex.test($(this).val())) {
			// If reg ex matches strong password
			$('#passwordStrength').removeClass().addClass('alert alert-success').html('Good Password!');
		} 
	
		else if (mediumRegex.test($(this).val())) {
			// If medium password matches the reg ex
			$('#passwordStrength').removeClass()
				.addClass('alert alert-info')
				.html('Password must include capital letters, lowercase letters and numbers!');
		}	 
	
		else {
			// If password is not ok
			$('#passwordStrength').removeClass().addClass('alert alert-error').html('Weak Password, try using capital letters, lowercase letters and numbers.');
		}

		return true;
	});
	
	// catch the submit form, used to tell the user if password is good enough
	$('#create-guest, #admin-change-password').submit(function(){

		var password_strenght=$('#passwordStrength').text();

		if(password_strenght!='Good Password!'){
			alert('Password not strong enough');
			return false
		}

		return true;
	});
});		
</script>	
