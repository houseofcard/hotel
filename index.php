<link rel="stylesheet" type="text/css" href="styles/index.css">

<!--index-->
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.3.4/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.3.4/owl.theme.default.css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.3.4/animate.css">
<!---->

<?php
// core configuration
include_once 'config/core.php';

// headings
include_once 'layout/template_header.php';
include_once 'layout/template_booking.php';

// to prevent undefined index notice
$action = isset($_GET['action']) ? $_GET['action'] : "";

if($action=='already_logged_in'){
	echo "<p>You are already logged in.</p>";
}
// if user was not admin
else if($action=='not_admin'){
	echo "<p>You cannot access that page.</p>";
}
?>

<div class="body_content">
	<div class="container">
		<div class="row row-eq-height">
			<div class="col">
				<div class="section_title text-center">
					<div>Welcome</div>
					
					<?php	
					if($action=='login_success'){
						echo $_SESSION['firstname'];
					}
					?>
					
					<h1>Amazing Hotel in front of the Sea</h1>
				</div>
			</div>
			<div class="intro_row">
			<!--<div class="row intro_row text-center">-->
				<p>Maecenas sollicitudin tincidunt maximus. Morbi tempus malesuada erat sed pellentesque. Donec pharetra mattis nulla, id laoreet neque scelerisque at. Quisque eget sem non ligula consectetur ultrices in quis augue. Donec imperd iet leo eget tortor dictum, eget varius eros sagittis. Curabitur tempor dignissim massa ut faucibus sollicitudin tinci dunt maximus. Morbi tempus malesuada erat sed pellentesque. Donec pharetra mattis nulla, id laoreet neque scele risque at. Quisque eget sem non ligula consectetur ultrices in quis augue. Donec imperdiet leo eget tortor dictum, eget varius eros sagittis. Curabitur tempor dignissim massa ut faucibus.</p>
			</div>
			<div class="row gallery_row">
				<div class="col">
								
					<div class="gallery_slider_container">
						<div class="owl-carousel owl-theme gallery_slider">

							<!-- Slide -->
							<div class="gallery_slide">
								<img src="images/index/gallery_1.jpg" Width="465" Height="534" alt="">
							</div>
						
							<!-- Slide -->
							<div class="gallery_slide">
								<img src="images/index/gallery_2.jpg" Width="465" Height="534" alt="">
							</div>
							
							<!-- Slide -->
							<div class="gallery_slide">
								<img src="images/index/gallery_3.jpg" Width="465" Height="534" alt="">
							</div>
						
							<!-- Slide -->
							<div class="gallery_slide">
								<img src="images/index/gallery_4.jpg" Width="465" Height="534" alt="">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>			
	
	<!-- Rooms -->
	<div class="rooms_right container_wrapper">
		<div class="container">
			<div class="row row-eq-height">
			
				<!-- Rooms Image -->
				<div class="col-xl-6 order-xl-3 order-4">
					<div class="rooms_slider_container">
						<div class="owl-carousel owl-theme rooms_slider">
              
							<!-- Slide -->
							<div class="slide">
								<div class="background_image" style="background-image:url(images/index/double_suite_1.jpg)"></div>
							</div>

							<!-- Slide -->
							<div class="slide">
								<div class="background_image" style="background-image:url(images/index/double_suite_2.jpg)"></div>
							</div>

							<!-- Slide -->
							<div class="slide">
								<div class="background_image" style="background-image:url(images/index/double_suite_3.jpg)"></div>
							</div>
						</div>
					</div>
				</div>

				<!-- Rooms Content -->
				<div class="col-xl-6 order-xl-4 order-3">
					<div class="rooms_right_content">
						<div class="section_title">
							<div>Rooms</div>
							<h1>Luxury Double Suite</h1>
						</div>
						<div class="rooms_text">
							<p>Maecenas sollicitudin tincidunt maximus. Morbi tempus malesuada erat sed pellentesque. Donec pharetra mattis nulla, id laoreet neque scelerisque at. Quisque eget sem non ligula consectetur ultrices in quis augue. Donec imperd iet leo eget tortor dictum, eget varius eros sagittis. Curabitur tempor dignissim massa ut faucibus sollicitudin tinci dunt maximus. Morbi tempus malesuada erat sed pellentesque.</p>
						</div>
						<div class="rooms_list">
							<ul>
								<li class="d-flex flex-row align-items-center justify-content-start">
									<img src="images/check.png" alt="">
									<span>Morbi tempus malesuada erat sed</span>
								</li>
								<li class="d-flex flex-row align-items-center justify-content-start">
									<img src="images/check.png" alt="">
									<span>Tempus malesuada erat sed</span>
								</li>
								<li class="d-flex flex-row align-items-center justify-content-start">
									<img src="images/check.png" alt="">
									<span>Pellentesque vel neque finibus elit</span>
								</li>
							</ul>
						</div>
						<div class="rooms_price">$125-$150/<span>Adult A Night</span></div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Rooms -->
	<div class="rooms_left container_wrapper">
		<div class="container">
			<div class="row row-eq-height">
        
				<!-- Rooms Content -->
				<div class="col-xl-6">
					<div class="rooms_left_content">
						<div class="section_title">
						<div>Rooms</div>
							<h1>Luxury Single Room</h1>
						</div>
						<div class="rooms_text">
							<p>Maecenas sollicitudin tincidunt maximus. Morbi tempus malesuada erat sed pellentesque. Donec pharetra mattis nulla, id laoreet neque scelerisque at. Quisque eget sem non ligula consectetur ultrices in quis augue. Donec imperd iet leo eget tortor dictum, eget varius eros sagittis. Curabitur tempor dignissim massa ut faucibus sollicitudin tinci dunt maximus. Morbi tempus malesuada erat sed pellentesque.</p>
						</div>
						<div class="rooms_list">
							<ul>
								<li class="d-flex flex-row align-items-center justify-content-start">
									<img src="images/check.png" alt="">
									<span>Morbi tempus malesuada erat sed</span>
								</li>
								<li class="d-flex flex-row align-items-center justify-content-start">
									<img src="images/check.png" alt="">
									<span>Tempus malesuada erat sed</span>
								</li>
								<li class="d-flex flex-row align-items-center justify-content-start">
									<img src="images/check.png" alt="">
									<span>Pellentesque vel neque finibus elit</span>
								</li>
							</ul>
						</div>
						<div class="rooms_price">$100-$125/<span>Adult A Night</span></div>
					</div>
				</div>

				<!-- Rooms Image -->
				<div class="col-xl-6">
					<div class="rooms_slider_container">
						<div class="owl-carousel owl-theme rooms_slider">
              
							<!-- Slide -->
							<div class="slide">
								<div class="background_image" style="background-image:url(images/index/single_room_1.jpg)"></div>
							</div>

							<!-- Slide -->
							<div class="slide">
								<div class="background_image" style="background-image:url(images/index/single_room_2.jpg)"></div>
							</div>

							<!-- Slide -->
							<div class="slide">
								<div class="background_image" style="background-image:url(images/index/single_room_3.jpg)"></div>
							</div>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>	

	<!-- Discover -->
	<div class="discover">

		<!-- Discover Content -->
		<div class="discover_content">
			<div class="container">
				<div class="row">
					<div class="col">
					<!--<div class="col-lg-5">-->
						<div class="section_title text-center">
							<div>Hotel</div>
							<h1>Discover Marimar Hotel</h1>
						</div>
					</div>
					<div class="row discover_row">
						<div class="col-lg-5">
							<div class="discover_highlight">
								<p>Morbi tempus malesuada erat sed pellentesque. Donec pharetra mattis nulla, id laoreet neque scelerisque at. Quisque eget sem non ligula consectetur.</p>
							</div>
						</div>
						<div class="col-lg-7">
							<div class="discover_text">
								<p>Morbi tempus malesuada erat sed pellentesque. Donec pharetra mattis nulla, id laoreet neque scelerisque at. Quisque eget sem non ligula consectetur ultrices in quis augue. Donec imperd iet leo eget tortor dictum, eget varius eros sagittis. Curabitur tempor dignissim massa ut faucibus sollicitudin tinci dunt maximus. Morbi tempus malesuada erat sed pellentesque. Donec pharetra mattis. Donec pharetra mattis nulla, id laoreet neque scelerisque at. Morbi tempus malesuada erat sed pellentesque. Donec pharetra mattis nulla, id laoreet neque scelerisque at. Quisque eget sem non ligula consectetur ultrices in quis augue.</p>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Discover Slider -->
			<div class="discover_slider_container">
				<div class="owl-carousel owl-theme discover_slider">
        
					<!-- Slide -->
					<div class="slide">
						<div class="background_image" style="background-image:url(images/index/discover_1.jpg)"></div>
						<div class="d-flex flex-column align-items-center justify-content-center">
							<h1>Weddings</h1>
						</div>
					</div>

					<!-- Slide -->
					<div class="slide">
						<div class="background_image" style="background-image:url(images/index/discover_2.jpg)"></div>
						<div class="d-flex flex-column align-items-center justify-content-center">
							<h1>Parties</h1>
						</div>
					</div>

					<!-- Slide -->
					<div class="slide">
						<div class="background_image" style="background-image:url(images/index/discover_3.jpg)"></div>
						<div class="d-flex flex-column align-items-center justify-content-center">
							<h1>Relax</h1>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Testimonials -->
	<div class="testimonials">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="section_title text-center">
						<div>Clients</div>
						<h1>Testimonials</h1>
					</div>
				</div>
			</div>
			<div class="row testimonials_row">
				<div class="col">
          
					<!-- Testimonials Slider -->
					<div class="testimonials_slider_container">
						<div class="owl-carousel owl-theme testimonials_slider">

							<!-- Slide -->
							<div>
								<div class="testimonial_text text-center">
									<p>Maecenas sollicitudin tincidunt maximus. Morbi tempus malesuada erat sed pellentesque. Donec pharetra mattis nulla, id laoreet neque scelerisque at. Quisque eget sem non ligula consectetur ultrices in quis augue. Donec imperd iet leo eget tortor dictum, eget varius eros sagittis. Curabitur tempor dignissim massa ut faucibus sollicitudin tinci dunt maximus. Morbi tempus malesuada erat sed pellentesque. Donec pharetra mattis nulla, id laoreet neque scele risque at. Quisque eget.</p>
								</div>
								<div class="testimonial_author text-center">
									<div class="testimonial_author_image"><img src="images/index/author_1.jpg" alt=""></div>
									<div class="testimonial_author_name">Maria Smith<span> Client</span></div>
								</div>
							</div>

							<!-- Slide -->
							<div>
								<div class="testimonial_text text-center">
									<p>Maecenas sollicitudin tincidunt maximus. Morbi tempus malesuada erat sed pellentesque. Donec pharetra mattis nulla, id laoreet neque scelerisque at. Quisque eget sem non ligula consectetur ultrices in quis augue. Donec imperd iet leo eget tortor dictum, eget varius eros sagittis. Curabitur tempor dignissim massa ut faucibus sollicitudin tinci dunt maximus. Morbi tempus malesuada erat sed pellentesque. Donec pharetra mattis nulla, id laoreet neque scele risque at. Quisque eget.</p>
								</div>
								<div class="testimonial_author text-center">
									<div class="testimonial_author_image"><img src="images/index/author_1.jpg" alt=""></div>
									<div class="testimonial_author_name">Maria Smith<span> Client</span></div>
								</div>
							</div>

							<!-- Slide -->
							<div>
								<div class="testimonial_text text-center">
									<p>Maecenas sollicitudin tincidunt maximus. Morbi tempus malesuada erat sed pellentesque. Donec pharetra mattis nulla, id laoreet neque scelerisque at. Quisque eget sem non ligula consectetur ultrices in quis augue. Donec imperd iet leo eget tortor dictum, eget varius eros sagittis. Curabitur tempor dignissim massa ut faucibus sollicitudin tinci dunt maximus. Morbi tempus malesuada erat sed pellentesque. Donec pharetra mattis nulla, id laoreet neque scele risque at. Quisque eget.</p>
								</div>
								<div class="testimonial_author text-center">
									<div class="testimonial_author_image"><img src="images/index/author_1.jpg" alt=""></div>
									<div class="testimonial_author_name">Maria Smith<span> Client</span></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>	
		</div>
    </div>
</div>


<?php
	include_once 'layout/template_footer.php';
?>