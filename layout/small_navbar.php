<?php
// core configuration
include_once 'config/core.php';
?>
<?php
// connect to database
include_once 'config/database.php';

// include objects and classes
include_once 'objects/cart_item.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$cart_item = new CartItem($db);
?>

<div class="menuSm">  
	<div class="navbar navbar-fixed-top  navbar-inverse">   
		<div class="navbar-collapse ">
			<div class="sm-ul navbar-custom-menu ">
				<ul class=" navbar-nav d-flex flex-row align-items-center justify-content-start pull-right">
				
					<?php 
					if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true && $_SESSION['access_level']=='Customer'){
					?> 
						<li class="user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" 
								style="color:#EEE"><i class="glyphicon glyphicon-user"></i><?php echo $_SESSION['firstname']. ' ' . $_SESSION['lastname']; ?> 
							</a>
							<ul class="dropdown-menu nav nav-stacked">    
								<li>
									<a href="edit_profile.php">Edit Profile </a>
								</li>
								<li>
									<a href="change_password.php">Change Password </a>
								</li>
								
								<li>
									<a href="orders.php">Bookings </a>
								 </li>
								<li>
									<a href="logout.php">Logout </a>
								 </li>
							</ul>
						</li>
					<?php }else { ?>
						<li>
							<a href="login.php"  style="color:#EEE" title="Login Guest"><i class="glyphicon glyphicon-user"></i>Login</a>
						</li>
						<li>
							<a href="register.php" style="color:#EEE" title="Register Guest"  href="">Register</a>
						</li>
					<?php } ?>
				
					<!-- link to the "Cart" page, highlight if current page is cart.php -->
					<a href="booking.php">

						<li>
						<?php
						// return count, session user_id was set in core.php
						$cart_item->guestid=$_SESSION['user_id'];
						$cart_count=$cart_item->countAll();
						?>
						</li>
						Cart <?php echo $cart_count; ?> Items <i class="glyphicon glyphicon-shopping-cart"></i>
					</a>
						
				</ul>
			</div>	
		</div>	
	</div>
</div>	