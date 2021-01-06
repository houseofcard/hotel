<link rel="stylesheet" type="text/css"> <!--This is here to stop footer paralles image jumping around-->

<?php
// core configuration
include_once 'config/core.php';

// headings
include_once 'layout/template_header.php';
include_once 'layout/template_booking.php';

// connect to database
include_once 'config/database.php';

// include objects and classes
include_once 'objects/accomodation.php';
include_once 'objects/room.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// initialize objects
$accomodation = new Accomodation($db);
$room = new Room($db);

$stmt = $accomodation->listOfaccomodation();
?>
<div class="body_content">
	<div class="container">
	<!--<div class="container-fluid">-->
		<!-- Row for the card-->
		<div class="row justify-content-center">

			<?php
			while ($row_accomodation = $stmt->fetch(PDO::FETCH_ASSOC)){
		
				$accomid= $row_accomodation['ACCOMID'];
				$room->accomid=$accomid;
				$roomstotal=$room->countRooms();
				$accomodation = $row_accomodation['ACCOMODATION'];
				$pricerange = $row_accomodation['PRICERANGE'];
				$accomdesc = $row_accomodation['ACCOMDESC'];
				$roomimage = $row_accomodation['name'];
			?>
				<br>
				<div align="center">
				<!--<div class="room_image" align="center">-->
					<form>
					<!--<form method="POST" action="accomodation.php?id=<?php //echo $accomid ; ?>">-->
						<input type="hidden" name="PRICERANGE" value="<?php echo $pricerange ;?>">
						<input type="hidden" name="ACCOMID" value="<?php echo $accomid ;?>">
						
						<!--<div class="col-sm-6">-->
							<div class="card mx-auto" style="width:345px">
								<img class="card-img-top room_image"  src="images/<?php echo $roomimage ; ?>" alt="Room image description">
								<div class="card-body">
									<div class="rooms_title"><h2><?php echo $accomodation ;?></h2></div>
									<div class="rooms_text">
										<p align="left"><?php echo $accomdesc ;?></p>
										<p align="left"><?php echo $pricerange ;?></p>
									</div>
									<br>
									<div class="rooms_list">
										<ul>
											<li class="d-flex flex-row align-items-center justify-content-start">
												<img src="images/check.png" alt="">&nbsp;&nbsp;
												<p><span align="center">Total Rooms :   <?php echo $roomstotal ;?></span></p>
											</li>
										</ul>
									</div>
								</div>
							</div>
						<!--</div>	-->
						</form>
					<!--</form>-->	
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