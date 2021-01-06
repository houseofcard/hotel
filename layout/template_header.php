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
<link rel="stylesheet" type="text/css" href="plugins/font-awesome-4.7.0/css/font-awesome.min.css">
<!-- -->

<!-- css-->
<link rel="stylesheet" type="text/css" href="styles/template_header.css">
<link rel="stylesheet" type="text/css" href="styles/main_styles.css">
<link rel="stylesheet" type="text/css" href="styles/small_navbar.css">

<link rel="stylesheet" type="text/css" href="styles/bootstrap-4.1.2/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="styles/bootstrap.css">

<!-- jquery-->
<script src="js/jquery-3.3.1.min.js"></script>
<script src="styles/bootstrap-4.1.2/bootstrap.min.js"></script>
<script src="plugins/parallax-js-master/parallax.min.js"></script>
<script src="js/custom.js"></script>
<!--  -->

<!-- is a positioning engine -->
<script src="styles/bootstrap-4.1.2/popper.js"></script>
<!--  -->

<!--index -- needs to be in template_header-->
<script src="plugins/OwlCarousel2-2.3.4/owl.carousel.js"></script>
<!--  -->

</head>
<body>
<?php include_once 'small_navbar.php'; ?> 
<br/>

	<header class="header">
		<div class="d-flex flex-column align-items-center">
			<!-- Logo -->
			<div class="logo">
				<img class="logo_1" src="images/logo.png" width="120" height="154" alt="">
			</div>
			
			<!-- Main Nav -->
			<nav class="main_nav">
				<ul class="d-flex flex-row align-items-center justify-content-start">
					<li><a href="index.php">Home</a></li>
					<li><a href="aboutus.php">About Us</a></li>
					<li><a href="room_rates.php">Rooms</a></li> 
					<li><a href="contact.php">Contact</a></li>
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
	
	<!-- Home -->
	<div class="home">
		<div class="parallax_background parallax-window" data-parallax="scroll" data-image-src="images/home.jpg" data-speed="0.8"></div>
			<div class="container">
				<div class="home_container align-items-center">
				<!--<div class="home_container d-flex flex-column align-items-center justify-content-center">-->
					<div class="home_title"><h1>Book Your Stay</h1></div>
				<div class="home_text">Fusce erat dui, venenatis et erat in, vulputate dignissim lacus. Donec vitae tempus dolor, sit amet elementum lorem. Ut cursus tempor turpis.</div>
			</div>
		</div>
	</div>
	
