<link rel="stylesheet" type="text/css" href="../styles/bootstrap-4.1.2/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../styles/responsive.css">
<link rel="stylesheet" type="text/css" href="../styles/custom-navbar.css">
<link rel="stylesheet" type="text/css" href="../styles/bootstrap.css">
<!--this allow the customer admin toggle button to change shade on click-->
<script src="../styles/bootstrap-4.1.2/bootstrap.min.js"></script>
<script src="../js/jquery-3.3.1.min.js"></script>
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

echo "<caption><h2 align='center'>Change Password</h2></caption>";

// if the form was submitted
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
	
<!-- HTML form for creating a guest -->
<form action='admin_change_password.php' method='post' id='admin-change-password'>

     <div class='table-responsive'>
		<table class='table table-hover table-bordered'>

	       <tr>
				<td width='30%'>Current Password</td>
				<td width='70%'><input type='password' name='current_password' class='form-control' required /></td>
			</tr>
			<tr>
				<td>New Password</td>
				<td><input type='password' name='password' class='form-control' required id='passwordInput' /></td>
			</tr>
			<tr>
				<td>Confirm New Password</td>
				<td>
					<input type='password' name='confirm_password' class='form-control' required id='confirmPasswordInput' />
					<p>
						<div class="" id="passwordStrength"></div>
					</p>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<button type="submit" class="btn btn-primary">
						<span class="glyphicon glyphicon-edit"></span> Change Password
					</button>
				</td>
			</tr>
		
	    </table>
	</div>
</form>

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
