<!DOCTYPE html>
<html lang="en">
<head>
<title>Marimar</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="Marimar Hotel template project">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" >
<!-- -->

<!-- css-->
<link rel="stylesheet" type="text/css" href="styles/admin_template_header.css">
<link rel="stylesheet" type="text/css" href="styles/admin_main_styles.css">
<link rel="stylesheet" type="text/css" href="../styles/bootstrap-4.1.2/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../styles/bootstrap.css">

<!-- jquery-->
<script src="../js/jquery-3.3.1.min.js"></script>
<script src="../styles/bootstrap-4.1.2/bootstrap.min.js"></script>

</head>
<body>
<?php include_once 'admin_small_navbar.php'; ?> 
<br/>
<div class="super_container">
	<header class="header">
		<div class="header_content d-flex flex-column align-items-center justify-content-lg-end justify-content-center">
      
			<!-- Logo -->
			<div class="logo">
				<img class="logo_1" src="images/logo.png" alt="">
			</div>
			
			<!-- Main Nav -->
			<nav class="main_nav">
				<ul class="d-flex flex-row align-items-center justify-content-start">
					<li><a href="admin_accomodation.php">Accomodation</a></li>
					<li><a href="admin_roomtype.php">Room Type</a></li>
					<li><a href="admin_room.php">Rooms</a></li>
					<li><a href="admin_order.php">Orders</a></li> 
				</ul>
				<ul class="d-flex flex-row align-items-center justify-content-start">	
					<li><a href="admin_reservation.php">Reservations</a></li>
					<li><a href="admin_guest.php">Guests</a></li>
					<li><a href="admin_comments.php">Comments</a></li>
				</ul>
			</nav>

			<!-- Social -->
			<div class="social">
				<ul class="d-flex flex-row align-items-center justify-content-start">
					<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
					<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                </ul>
			</div>
		
		</div>
    </header>
		