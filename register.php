<link rel="stylesheet" type="text/css" href="styles/login.css">

<?php
ob_start();  //this is so location header works
?>
<?php
// core configuration
include_once 'config/core.php';

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
$page_title = "Register";

// include login checker
include_once "login_checker.php";

// make it work in PHP 5.4
include_once "libs/php/pw-hashing/passwordLib.php";
?>
<div class="login">
	<div class="container">
		<div class="row">
			<div class="col">
				<h1>Register</h1>
				
				<?php

				if ($_POST){

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
					$guest->access_level='Customer';
					$guest->current_member='yes';
					$guest->g_email = $_POST['email']; 
					$guest->g_password = $_POST['password']; 

					// make sure do not create another guest when that guest already exists
					if($guest->emailAlreadyExists()){
						echo "<p>Email already exists in our databse.</p>";
						echo "<p>Try again with a different email.</p>";
					}

					else{	
						if($guest->createGuest()){
						// tell user new guest was created
							echo "<p>Guest was created.</p>";
						}else{
							echo "<p>Unable to create guest.</p>";
						}
					}
				}
				?>
				
				<form method="post" action="register.php" class='login_form' id='register'>
	
					<div class="row">
						<input type='text' name='first_name' class='login_input' placeholder="First Name" required>
					</div>
					<div class="row">
						<input type='text' name='last_name' class='login_input' placeholder="Last Name" required>
					</div>
					<div class="row">	
						<input type='text' name='address' class='login_input' placeholder="Address" required>
					</div>
					<div class="row">
						<input type='text' name='city' class='login_input' placeholder="City" required>
					</div>
					<div class="row">
						<input type='text' name='country' class='login_input' placeholder="Country" required>
					</div>
					<div class="row">
						<input type='text' name='zip' class='login_input' placeholder="Zip Code" required>
					</div>
					<div class="row">
						<input type='text' name='phone' class='login_input' placeholder="Phone Number" required>
					</div>
					<div class="row">
						<p>Date of Birth</p>
					</div>
					<div class="row">
						<input type='date' name='dbirth' class='login_input'  required>
					</div>
					<div class="row">
						<input type='text' name='nationality' class='login_input' placeholder="Nationality" required>
					</div>
					<div class="row">
						<td><input type='text' name='company_name' class='login_input' placeholder="Company Name">
					</div>
					<div class="row">
						<input type='text' name='company_address' class='login_input' placeholder="Company Address">
					</div>
					<div class="row">
						<input type='text' name='email' class='login_input' placeholder="Email Address" required>
					</div>
					<div class="row">	
						<input type='password' name='password' class='login_input' placeholder="Password" required id='passwordInput'>
					</div>	
					<div class="row">
						<input type='password' name='confirm_password' class='login_input' placeholder="Confirm Password" required id='confirmPasswordInput'>
					</div>
					<div class="row">
						<div class="" id="passwordStrength"></div>
					</div>
					<div class="row">	
						<p>&nbsp;I <input type="checkbox" name="condition" value="checkbox" required/>
						Agree the <a class="toggle-modal"  onclick="OpenPopupCenter('terms_condition.php','Terms And Codition','600','600')" /> <b>TERMS AND CONDITIONS </b></a> of this Hotel</p> 
					</div>
					<div class="row justify-content-center">
						<button type="submit" name="gsubmit" class="button">REGISTER</button> 
					</div>
					
				</form>
			</div>
		</div>
	</div>
</div>
<?
include_once 'layout/template_footer.php';
?>
		
<script language="javascript" type="text/javascript">
 
function OpenPopupCenter(pageURL, title, w, h) {
    var left = (screen.width - w) / 2;
    var top = (screen.height - h) / 4;  // for 25% - devide by 4  |  for 33% - devide by 3
    var targetWin = window.open(pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
} 
</script>

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
	$('#register, #change-password').submit(function(){

		var password_strenght=$('#passwordStrength').text();

		if(password_strenght!='Good Password!'){
			alert('Password not strong enough');
			return false
		}

		return true;
	});

});		
</script>	
	
