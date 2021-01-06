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
$page_title = "Change Password";

// include login checker
include_once "login_checker.php";

// make it work in PHP 5.4
include_once "libs/php/pw-hashing/passwordLib.php";
?>
<div class="login">
	<div class="container">

<?php	
		// if HTML form was posted / submitted
		if($_POST){

			// read guest details to get current password
			// read guest record based on session user id value
			$guest->guestid=$_SESSION['user_id'];
			$guest->passwordDetails();
	
			// check if submitted current_password is correct
			if(password_verify($_POST['current_password'], $guest->g_password)){

				// new password
				$guest->g_password=$_POST['password'];

				// get user id from session
				$guest->guestid=$_SESSION['user_id'];

				// update user information
				if($guest->changePassword()){

					// tell the user it was updated
					echo "<p>Password was changed.</p>";
				}

				// tell the user update was failed
				else{
					echo "<p>Unable to change password.</p>";
				}
			}

			// if submitted current password is wrong
			else{
				echo "<p>Current password is incorrect.</p>";
			}
		}
		?>

		<div class="row">
			<div class="col">
				
				<h1>Change Password</h1>
				<!-- HTML form to update user -->
				<form action='change_password.php' method='post' class='login_form' id='change-password'>
					
					<div class="row">
						<input type='password' name='current_password' class='login_input' placeholder="Current Password" required />
					</div>
					<div class="row">
						<input type='password' name='password' class='login_input' placeholder="New Password" required id='passwordInput' />
					</div>
					<div class="row">
						<input type='password' name='confirm_password' class='login_input' placeholder="Confirm Password" required id='confirmPasswordInput'>
					</div>		
					<div class="row">
						<div class=" " id="passwordStrength"></div>
					</div>
					<div class="row">
						<button type="submit" name="gsubmit" class="button">CHANGE PASSWORD</button> 
					</div>		
				</form>
			</div>
		</div>
	</div>
</div>

<?
include_once 'layout/template_footer.php';
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