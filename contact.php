<link rel="stylesheet" type="text/css" href="styles/contact.css">

<!--<link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" />-->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.1.0/dist/leaflet.css" integrity="sha512-wcw6ts8Anuw10Mzh9Ytw4pylW8+NAD4ch3lqm9lzAsTxg0GFeJgoAtxuCLREZSC5lUXdVyo/7yfsqFjQ4S+aKw==" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.1.0/dist/leaflet.js" integrity="sha512-mNqn2Wg7tSToJhvHcqfzLMU6J4mkOImSPTxVZAdo+lcPlk+GhZmYgACEe0x35K7YzW1zJ7XyJV/TT1MrdXvMcA==" crossorigin=""></script>

<?php
ob_start();  //this is so location header works
?>
<?php
// core configuration
include_once 'config/core.php';

// headings
include_once 'layout/template_header.php';
include_once 'layout/template_booking.php';

// connect to database
include_once 'config/database.php';

// include objects and classes
include_once 'objects/comments.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$comments = new Comments($db);
?>

<!-- Comment -->
<?php
if(isset($_POST['contact'])){
	
	$name= $_POST['name'];
	$email= $_POST['email'];
	$subject= $_POST['subject'];
	$message= $_POST['message'];
	
	$comments->comment_name=$name;
	$comments->comment_email=$email;
	$comments->subject=$subject;
	$comments->message=$message;
		
	if($comments->createComment()){
		header('Location: index.php');
	} else {
		echo "  ";
	}
}
?>

<div class="body_content">
    <div class="container">
		<div class="row">
			<div class="col">
				<div class="section_title">
					<div>Ciao</div>
					<h1>Say Hello</h1>
				</div>
				<div class="contact_text">
					<p>Maecenas sollicitudin tincidunt maximus. Morbi tempus malesuada erat sed pellentesque. Donec pharetra mattis nulla, id laoreet neque scelerisque at. Quisque eget sem non ligula consectetur ultrices in quis augue. Donec imperd iet leo eget tortor dictum, eget varius eros sagittis.</p>
				</div>
				<div class="contact_form_container">
					<form method="POST"  action="contact.php" class="contact_form text-center">
						<div class="row">
							<div class="col-lg-6">
								<input type="text" class="contact_input" name = "name" placeholder="Your name" required="required">
							</div>
							<div class="col-lg-6">
								<input type="email" class="contact_input" name = "email" placeholder="Your email" required="required">
							</div>
						</div>
						<input type="text" class="contact_input" name = "subject" placeholder="Subject">
						<textarea class="contact_input" name = "message" placeholder="Message" required="required"></textarea>
						<button class="button" type="submit" id="contact" name="contact">SEND MESSAGE</button>
					</form>
				</div>
			</div>
		</div>
	</div>
   	
	<div class="contact_map_container">
		<div class="map">
			<div id="google_map" class="google_map">
				<div class="map_container">
					<div id="map">
						<script>
						var mymap = L.map('map').setView([33.0, -96.0], 2);
						//var mymap = L.map('map').setView([19.464204, 5.189982], 2);

						L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
						maxZoom: 18,
						attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
						'<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
						'Imagery © <a href="http://mapbox.com">Mapbox</a>',
						id: 'mapbox.streets'
						}).addTo(mymap);
		
						//L.marker([33.016540, -96.529620]).addTo(mymap).bindPopup();
						L.marker([33.016540, -96.529620]).addTo(mymap);

						</script>
					</div>
				</div>
			</div>
		</div>
	</div>
  
	<!-- Contact Map Content -->
	<div class="contact_map_content">
		<div class="d-flex flex-column align-items-center justify-content-center">
			<img class="contact_info_logo_1" src="images/logo.png" alt="">
			<div class="contact_info_list">
				<ul class="text-center">
					<li>132 Liberty Streetelit, Plano, Texas</li>
					<li>hotelTexas@home.com</li>
					<li>214-805-4428</li>
				</ul>
			</div>	
		</div>
	</div>
</div>

 <?php
	include_once 'layout/template_footer.php';
?>