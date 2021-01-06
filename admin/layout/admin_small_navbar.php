<link rel="stylesheet" type="text/css" href="styles/admin_small_navbar.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<?php
// core configuration
include_once '../config/core.php';
?>
<?php
// connect to database
include_once '../config/database.php';

// get database connection
$database = new Database();
$db = $database->getConnection();
?>

<div class="menuSm">  
	<div class="navbar navbar-fixed-top  navbar-inverse">   
		<div class="navbar-collapse ">
			<div class="sm-ul navbar-custom-menu ">
				<ul class="navbar-nav d-flex flex-row align-items-center justify-content-start pull-right">
				
					<li class="user-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" 
							style="color:#EEE"><i class="fa fa-user fa-fw"></i><?php echo $_SESSION['firstname']. ' ' . $_SESSION['lastname']; ?> 
						</a>
						<ul class="dropdown-menu nav nav-stacked">    
							<li>
								<a href="admin_edit_profile.php">Edit Profile </a>
							</li> 
							<li>
								<a href="admin_change_password.php">Change Password </a>
							</li>
							<li>
								<a href="admin_logout.php">Logout </a>
							</li> 
						</ul>
					</li>
				</ul>
			</div> 
		</div> 
	</div> 
</div> 