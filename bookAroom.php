<link rel="stylesheet" type="text/css"> <!--This is here to stop footer paralles image jumping around-->

<?php
// core configuration
include_once 'config/core.php';

// headings
include_once 'layout/template_header.php';

// connect to database
include_once 'config/database.php';

// include objects and classes
include_once 'objects/accomodation_image.php';
include_once 'objects/roomtype.php';
include_once 'objects/room.php';
include_once 'objects/reservation.php';
include_once 'objects/capacity.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$accomimage = new AccomodationImage($db);
$roomtype = new Roomtype($db);
$room = new Room($db);
$reservation = new Reservation($db);
$capacity = new Capacity($db);

$arrival = date_format(date_create( $_POST['arrival']),"Y-m-d");
$departure =date_format(date_create($_POST['departure']),"Y-m-d");
//this is were the problem with responsive web pages is (below)
$num_guests =  $_POST['guests'];
// this is were the problem with responsive web pages is (above)

$_SESSION['arrival']=$arrival;
$_SESSION['departure']=$departure;

$capacity->capacityid=$num_guests;

$stmt = $capacity->readByCapacityID();

$row_capacity = $stmt->fetch(PDO::FETCH_ASSOC);
$adult_guests = $row_capacity['C_ADULTS'];
$children_guests = $row_capacity['C_CHILDREN'];

$roomtype->adults=$adult_guests;
$roomtype->children=$children_guests;

$stmt2 = $roomtype->roomPersons();
?>
<div class="body_content">
	<div class="container">
	<!--<div class="container-fluid align-items-center justify-content-center d-flex">-->
		<!-- Row for the card-->
		<div class="row justify-content-center">
		<!--<div class="row my-auto">-->
			
			<?php
			while ($row_roomtype = $stmt2->fetch(PDO::FETCH_ASSOC)){
				$accomid= $row_roomtype['ACCOMID'];
				$room->accomid=$accomid;
				$roomstotal=$room->countRooms();	
				$price = $row_roomtype['PRICE'];
				$roomdesc = $row_roomtype['ROOMDESC'];
				$adults = $row_roomtype['ADULTS'];
				$children = $row_roomtype['CHILDREN'];
				$accomodation	= $row_roomtype['ACCOMODATION'];
		
				$reservation->accomid=$accomid;
				$reservation->arrival=$arrival;
				$reservation->departure=$departure;
	
				$restotal=$reservation->checkReservationDates();
			
				$remainingRooms=$roomstotal-$restotal;
			?>
				<br>
				<div align="center">
					<form method="POST" action="add_to_cart.php">
						<input type="hidden" name="ROOMPRICE" value="<?php echo $price ;?>">
						<input type="hidden" name="ACCOMID" value="<?php echo $accomid ;?>">
		
						<div class="card mx-auto" style="width: 345px">
							<?php
							$accomimage->accomid=$accomid;	
							$stmt_accom_image = $accomimage->readAll();
							while ($row_accom_image = $stmt_accom_image->fetch(PDO::FETCH_ASSOC)){
								$accom_image_name = $row_accom_image['name'];
							}
							?>
							
							<img class="card-img-top" src="images/<?php echo $accom_image_name; ?>" alt="Room image description">
       
							<div class="card-body">
								<div class="rooms_title"><h2><?php echo $accomodation ;?></h2></div>
								<div class="rooms_text">
									<p><?php echo $roomdesc ;?></p>
								</div>
								<div class="rooms_list">
									<ul>
										<li class="d-flex flex-row align-items-center justify-content-start">
											<img src="images/check.png" alt="">
											<input type="hidden" name="ADULTS" value="<?php echo $adults ;?>">
											<span>&nbsp;&nbsp;Number of Adults: <?php echo $adults ;?></span>
										</li> 
										<li class="d-flex flex-row align-items-center justify-content-start">
											<img src="images/check.png" alt="">	
											<input type="hidden" name="CHILDREN" value="<?php echo $children ;?>">
											<span>&nbsp;&nbsp;Number of Children: <?php echo $children ;?></span>
										</li> 
										<li class="d-flex flex-row align-items-center justify-content-start">
											<img src="images/check.png" alt="">
											<span>&nbsp;&nbsp;Remaining Rooms: <?php echo $remainingRooms ;?></span>
										</li>
									</ul>
								</div>
								<div class="rooms_price"><p><b>$<?php echo $price ;?>/<span>Night</b></span></p></div>
								<br>
								<button class="button" type="submit" id="booknow" name="booknow" id="booknow" name="booknow">BOOK NOW!</button>
							</div>
						</div>
					</form>
				</div>
			<?php
			}
			?>
		</div>
	</div>
</div>
<?php
include_once 'layout/template_footer.php';
?>