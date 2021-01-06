<link rel="stylesheet" type="text/css" href="styles/login.css">

<?php
ob_start();  //this is so location header works
?>
<?php
// core configuration
include_once 'config/core.php';

// headings
include_once 'layout/template_header.php';
include_once 'small_navbar.php';

// connect to database
include_once 'config/database.php';

// include objects and classes
include_once 'objects/guest.php';
include_once 'objects/cart_item.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$guest = new Guest($db);
$cart_item = new CartItem($db);

// set page title
$page_title = "Login";

// include login checker
include_once "login_checker.php";

// make it work in PHP 5.4
include_once "libs/php/pw-hashing/passwordLib.php";

// default to false
$access_denied=false;
?>
<div class="login">;
	<div class="container">

<?php
		if ($_POST){
			// check if email and password are in the database	
			$guest->g_email = $_POST['email']; 
	
			// check if email exists, also get user details using this emailExists() method
			$email_exists = $guest->emailExists();
	
			// validate login
			if($email_exists && password_verify($_POST['password'], $guest->g_password) && $guest->current_member=='yes'){
			
				// check if valid temporary guest id exists
				if(isset($_SESSION['user_id'])){
			
					// update cart_items in the database
					$cart_item->guestid=$guest->guestid;
					$cart_item->updateGuestId();
				}

				// set the session value to true
				$_SESSION['logged_in'] = true;
				$_SESSION['user_id'] = $guest->guestid;
				$_SESSION['firstname'] = htmlspecialchars($guest->g_fname, ENT_QUOTES, 'UTF-8') ;
				$_SESSION['lastname'] = $guest->g_lname;
				$_SESSION['access_level'] = $guest->access_level;
				
				if($guest->access_level=='Admin'){
					header("Location: admin/admin_guest.php?action=login_success");
				}

				// else, redirect only to 'Customer' section
				else{
					header('Location: index.php?action=login_success');
				}
			}
			// if username does not exist or password is wrong
			else{
				$access_denied=true;
			}
		}

		// create action variable
		$action = isset($_GET['action']) ? $_GET['action'] : "";

		// tell the user he is not yet logged in
		if($action =='not_yet_logged_in'){
			echo "<p>Please login.</p>";
		}

		// tell the user to login
		else if($action=='please_login'){
			echo "<p>Please login to access that page.</p>";
		}
		
		// tell the user if access denied
		if($access_denied){
			echo "<p>Access Denied.</p>";
			echo "<p>Your username or password maybe incorrect.</p>";
			echo "<br>";
			echo "<p>If you have fogotten your username or password email:</p>  ";
			echo "<p>forgottenlogin@mirimar.com</p>";
			echo "<br>";
		}
		?>

		<div class="row">
			<div class="col">
				<div class="row">
					<h1 style="display: inline-block;">Login
					<a style="display: inline-block;" href="register.php" data-title="Register New Guest">  Register</a></h1> 	
				</div>
				<form method="post" action="login.php" class="login_form">
					<div class="row">
						<input type='text' name='email' class='login_input' placeholder="Email" required>
					</div>
					<div class="row">
						<input type='password' name='password' class='login_input' placeholder="Password" required>
					</div>
					<div class="row justify-content-center">
						<button type="submit" name="gsubmit" class="button">SIGN IN</button> 
					</div>
				</form>   
			</div>
		</div>
	</div>	
</div>	
				
<?php
include_once 'layout/template_footer.php';
?> 